# Sample donated by Coretechs
# Updated By: SDK Support, Tech Ops
# Company: Paya, Inc.
# Sample for educational use only - not intended for production.
# If you have any questions regarding the sample or the Direct API please contact
# us at sdksupport@paya.com
import uuid
import hmac
import hashlib
import base64
import random
import time
import json
import requests
import logging

# These two lines enable debugging at httplib level (requests->urllib3->http.client)
# You will see the REQUEST, including HEADERS and DATA, and RESPONSE with HEADERS but without DATA.
# The only thing missing will be the response.body which is not logged.
try:
    import http.client as http_client
except ImportError:
    # Python 2
    import httplib as http_client
http_client.HTTPConnection.debuglevel = 1

# You must initialize logging, otherwise you'll not see debug output.
logging.basicConfig()
logging.getLogger().setLevel(logging.DEBUG)
requests_log = logging.getLogger("requests.packages.urllib3")
requests_log.setLevel(logging.DEBUG)
requests_log.propagate = True

# These are the Merchant Credentials, please feel free to use the prodvided
# Merchant ID and Merchant Key for testing. If you would like your own test 
# Merchant account with access to the Virtual Terminal, please request an account
# from sdksupport@paya.com
PAYA_MERCHANT_ID = '173859436515'
PAYA_MERCHANT_KEY = 'P1J2V8P2Q3D8'
# These are the Developer/API Credentials, please feel free to use the prodvided
# Client ID and Client Secret for initial testing. However, once you register 
# with the developer portal at https://developer.sagepayments.com you will need
# to setup an App under "My Apps", this will provide your unique Client ID and 
# Client Secret.
PAYA_CLIENT_ID = 'W8yvKQ5XbvAn7dUDJeAnaWCEwA4yXEgd'
PAYA_CLIENT_SECRET = b"iLzODV5AUsCGWGkr"
PAYA_API_ENDPOINT = 'https://api-cert.sagepayments.com/'


# the nonce can be any unique identifier -- guids and timestamps work well
nonce = int(time.time())  # uuid.uuid4()

# a standard unix timestamp. a request must be received within 60s
# of its timestamp header.
timestamp = int(time.time())


# setting up the request data itself
verb = "POST"
url = "https://api-cert.sagepayments.com/bankcard/v1/charges?type=Sale"
# url = "http://requestb.in" # This is a great alternative URL for testing. Please
# keep in mind Requestb.in is not managed by Paya, Inc.

requestData = {
    # this is a pretty minimalistic example...
    # complete reference material is available on the dev portal. A more detailed
    # set of requests can be viewed at https://developer.sagepayments.com/bankcard/apis/post/charges
    "Ecommerce": {
        "orderNumber": "Invoice{id}".format(
            id=random.randint(
                100,
                10000
            )
        ),
        "amounts": {
            "tip": "0",
            "total": "7",
            "tax": "0",
            "shipping": "0"
        },
        "cardData": {
            "number": "4111111111111111",
            "expiration": "0621",
            "cvv": "123"
        }
    }
}

# convert to json for transport
payload = json.dumps(requestData)

# the request is authorized via an HMAC header that we generate by
# concatenating certain info, and then hashing it using our client key
toBeHashed = "{verb}{url}{payload}{PAYA_MERCHANT_ID}{nonce}{timestamp}".format(
    verb=verb,
    url=url,
    payload=payload,
    PAYA_MERCHANT_ID=PAYA_MERCHANT_ID,
    nonce=nonce,
    timestamp=timestamp,
)

# build the authorization for the header. With python it is not necessary to
# convert the hmac to hex prior to base64 encoding it.
digest = hmac.new(PAYA_CLIENT_SECRET, msg=toBeHashed.encode('utf-8'), digestmod=hashlib.sha512).digest()
signature = base64.b64encode(digest).decode()

# submit the POST with the appropriate headers.
r = requests.post(
    url,
    headers={
        'clientId': PAYA_CLIENT_ID,
        'merchantId': PAYA_MERCHANT_ID,
        'merchantKey': PAYA_MERCHANT_KEY,
        'nonce': str(nonce),
        'timestamp': str(timestamp),
        'authorization': signature,
        'content-type': 'application/json'
    },
    data=payload
)
print(r.text)
