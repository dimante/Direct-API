// Sample donated by Andrew McRobb
// Company: Paya, Inc.
// Sample for educational use only - not intended for production.
// If you have any questions regarding the sample or the Direct API please contact
// us at sdksupport@paya.com

package main

import (
	"bytes"
	"crypto/hmac"
	"crypto/sha512"
	"encoding/base64"
	"encoding/json"
	"fmt"
	"io/ioutil"
	"math/rand"
	"net/http"
	"strconv"
	"time"
)

const (
	// These are the Merchant Credentials, please feel free to use the prodvided
	// Merchant ID and Merchant Key for testing. If you would like your own test 
	// Merchant account with access to the Virtual Terminal, please request an account
	// from sdksupport@paya.com
	PayaMerchantId  = "173859436515"
	PayaMerchantKey = "P1J2V8P2Q3D8"

	// These are the Developer/API Credentials, please feel free to use the prodvided
	// Client ID and Client Secret for initial testing. However, once you register 
	// with the developer portal at https://developer.sagepayments.com you will need
	// to setup an App under "My Apps", this will provide your unique Client ID and 
	// Client Secret.
	PayaClientId     = "W8yvKQ5XbvAn7dUDJeAnaWCEwA4yXEgd"
	PayaClientSecret = "iLzODV5AUsCGWGkr"

	Verb = "POST"
	Url  = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale"
)

type (
	AmountsData struct {
		Tip      float64 `json:"tip"`
		Total    float64 `json:"total"`
		Tax      float64 `json:"tax"`
		Shipping float64 `json:"shipping"`
	}

	CardData struct {
		Number     string `json:"number"`
		Expiration string `json:"expiration"`
		CVV        string `json:"cvv"`
	}

	ECommerceData struct {
		OrderNumber string      `json:"orderNumber"`
		Amounts     AmountsData `json:"amounts"`
		Card        CardData    `json:"cardData"`
	}

	// RequestData Request container for the request payload.
	// Set of requests can be viewed at https://developer.sagepayments.com/bankcard/apis/post/charges
	RequestData struct {
		Ecommerce ECommerceData `json:"Ecommerce"`
	}
)

var (
	requestData RequestData
	timestamp   int64
	nonce       int64
)

func init() {
	// a standard unix timestamp. a request must be received within 60s
	// of its timestamp header.
	timestamp = time.Now().Unix()

	// nonce can be any unique identifier -- guids and timestamps work well.
	nonce = time.Now().Unix()

	rand.Seed(timestamp)
	requestData = RequestData{
		ECommerceData{
			"Invoice" + strconv.Itoa(rand.Intn(1000-100+1)+100),
			AmountsData{
				0,
				7,
				0,
				0,
			},
			CardData{
				"4111111111111111",
				"0621",
				"123",
			},
		},
	}
}

func main() {
	payload, err := json.Marshal(requestData)

	if err != nil {
		fmt.Println(err)
		return
	}

	toBeHashed := Verb + Url + string(payload) + PayaMerchantId + strconv.Itoa(int(nonce)) + strconv.Itoa(int(timestamp))
	
	// build the authorization for the header. With python it is not necessary to
	// convert the hmac to hex prior to base64 encoding it.
	h := hmac.New(sha512.New, []byte(PayaClientSecret))
	h.Write([]byte(toBeHashed))
	signature := base64.StdEncoding.EncodeToString(h.Sum(nil))

	request, err := http.NewRequest(Verb, Url, bytes.NewBuffer(payload))
	request.Header = http.Header{
		"ClientId":      []string{PayaClientId},
		"MerchantId":    []string{PayaMerchantId},
		"MerchantKey":   []string{PayaMerchantKey},
		"Nonce":         []string{strconv.Itoa(int(nonce))},
		"Timestamp":     []string{strconv.Itoa(int(timestamp))},
		"Authorization": []string{signature},
		"Content-Type":  []string{"application/json"},
	}


	// Fire the request, timeout is set to 5 seconds if Paya takes too long to respond.
	client := &http.Client{Timeout: time.Second * 5}
	resp, err := client.Do(request)
	if err != nil {
		fmt.Println(err)
		return
	}

	// Read the response body and print it to the screen.
	defer resp.Body.Close()
	body, err := ioutil.ReadAll(resp.Body)

	if err != nil {
		fmt.Println(err)
		return
	}

	fmt.Println("body:", string(body), "\nstatus:", resp.StatusCode)
}
