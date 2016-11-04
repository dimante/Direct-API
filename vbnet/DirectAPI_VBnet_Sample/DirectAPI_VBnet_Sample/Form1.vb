Imports Newtonsoft.Json
Imports System.Security.Cryptography
Imports System.Text
Imports System.Net
Imports System.IO



Public Class Main

    '=====================================================
    'Sample Direct API request - VB.net
    'Thomas Hagan
    'Integration Consultant
    'Sage Payment Solutions
    'October 24th, 2016
    'Application is intended for instructional use only.
    'If you have any questions, please feel free to email
    'the Integration Support team at sdksupport@sage.com
    'Also, please make sure to register for API credentials
    'at our developer portal: https://developer.sagepayments.com
    '======================================================

    Private Sub btProcess_Click(sender As Object, e As EventArgs) Handles btProcess.Click

        'TH - Set the variables
        Dim merchantId As String = txtMerchantId.Text
        Dim merchantKey As String = txtMerchantKey.Text
        Dim clientId As String = txtClientId.Text
        Dim clientSecret As String = txtClientSecret.Text
        Dim url_sale As String = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale"
        'TH - http://requestb.in is a good resource for troubleshooting.
        'Dim url_sale As String = "http://requestb.in"
        Dim verb As String = "POST"
        Dim contentType As String = "application/json"
        Dim hash_authToken As Byte()
        Dim hash64_authToken As String
        Dim strOrderNumber As String = "Invoice " & Date.Now.Millisecond
        Dim strTotalAmount As String = "7"
        Dim strCardNumber As String = "5454545454545454"
        Dim strExpDate As String = "1220"

        'TH - Build request message
        '!!!!!!!!!!!!!!!!!!!!!>>>IMPORTANT<<<!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        'TH - This is the bare minimum request for a Sale or Authorization
        'More information may be needed to meet the requirements for a 
        'qualified transaction. Most card-not-present transactions and transactions
        'where the card was entered manually will require the addition of the street
        'address, zip code, and the cvv value to qualify for the best rate.
        '!!!!!!!!!!!!!!!!!!!!!>>>IMPORTANT<<<!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        Dim strRequest As Object = ""
        strRequest =
            "{""Ecommerce"":{""OrderNumber"":""" & strOrderNumber &
            """,""Amounts"":{""Total"":""" & strTotalAmount &
            """},""CardData"":{""Number"":""" & strCardNumber &
            """,""Expiration"":""" & strExpDate &
            """}}}"

        'TH - Display request message
        txtJSONrequest.Text = strRequest

        'TH - Building timestamp and nonce. Needs to be epoch in seconds.
        'TH - I am using the timestamp as my Nonce, but it is best to create a
        'seperate, unique value.
        Dim timestamp As Integer = (DateTime.UtcNow - New DateTime(1970, 1, 1, 0, 0, 0)).TotalSeconds
        Dim nonce As String = timestamp




        'TH - Build the Authorization
        Dim authToken As String = verb & url_sale & strRequest & merchantId & nonce & timestamp
        Using hmac As HMACSHA512 = New HMACSHA512(Encoding.ASCII.GetBytes(clientSecret))
            hash_authToken = hmac.ComputeHash(Encoding.ASCII.GetBytes(authToken))
        End Using
        hash64_authToken = Convert.ToBase64String(hash_authToken)

        'TH - Initiate a Web Request
        Dim web_request As HttpWebRequest = CType(HttpWebRequest.Create(url_sale), HttpWebRequest)

        'TH - Set the headers and details
        Dim web_request_headers As WebHeaderCollection = web_request.Headers
        Console.WriteLine("Configuring web_request to included headers for Sage Direct API")
        web_request_headers.Add("clientId: " & clientId)
        web_request_headers.Add("merchantId: " & merchantId)
        web_request_headers.Add("merchantKey: " & merchantKey)
        web_request_headers.Add("nonce: " & nonce)
        web_request_headers.Add("timestamp: " & timestamp)
        web_request_headers.Add("authorization: " & hash64_authToken)
        web_request.Method = verb

        'TH - Format the request
        Dim byteArray As Byte() = Encoding.ASCII.GetBytes(strRequest)

        'TH - Send the data
        web_request.ContentType = contentType
        web_request.ContentLength = byteArray.Length
        Dim datastream As Stream = web_request.GetRequestStream()
        datastream.Write(byteArray, 0, byteArray.Length)
        datastream.Close()

        'TH - Get the Response
        Try
            Dim web_response As WebResponse = web_request.GetResponse()
            Console.WriteLine(CType(web_response, HttpWebResponse).StatusDescription)
            datastream = web_response.GetResponseStream()


            Dim reader As New StreamReader(datastream)
            Dim responseFromServer As String = reader.ReadToEnd()
            Console.WriteLine(responseFromServer)
            reader.Close()
            datastream.Close()
            web_response.Close()

            'TH - Display response.
            txtJSONResponse.Text = responseFromServer

            'TH - Catch any errors
        Catch ex As Exception
            txtJSONResponse.Text = "Server Response: " & ex.Message
        End Try



    End Sub

    Private Sub btLoad_Click(sender As Object, e As EventArgs) Handles btLoad.Click

        'TH - Test Data. This is the test account infomation we provide
        'in the API Sandbox. Please contact us at sdksupport@sage.com if
        'you need a unique test account and receive the Merchant ID and
        'Merchant Key. In order to get your own Client ID and Client Secret
        'you must register at https://developer.sagepayments.com and setup
        'an App under My Apps. Please let us know if you have any questions.
        Dim merchantId As String = "173859436515"
        Dim merchantKey As String = "P1J2V8P2Q3D8"
        'TH - The Client ID and Client Key should be hard coded and not displayed
        'in the production product. These are your API credentials used for
        'security and tracking purposes.
        Dim clientId As String = "W8yvKQ5XbvAn7dUDJeAnaWCEwA4yXEgd"
        Dim clientSecret As String = "iLzODV5AUsCGWGkr"

        txtMerchantId.Text = merchantId
        txtMerchantKey.Text = merchantKey
        txtClientId.Text = clientId
        txtClientSecret.Text = clientSecret

    End Sub
End Class

