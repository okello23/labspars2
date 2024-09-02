<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

tr:nth-child(even) {
  background-color: rgba(150, 212, 212, 0.4);
}

th:nth-child(even),td:nth-child(even) {
  /* background-color: rgba(150, 212, 212, 0.4); */
}
</style>

Dear {{ $integration_request['app_name'] }} ,<br><br>
This is to inform you that the bearer token associated with Client ID <b>{{ $integration_request['client_id'] }} </b>
has been revoked effectively immediately.
<br>
Please cease all use of this token and ensure that it is no longer utilized in any system or application communications witht the Lab Spars.
Additionally, any ongoing processes or services relying on this token should be updated with alternative authorization mechanisms promptly

<br>
If you have any questions or concerns regarding this revocation, please don't hesitate to contact CPHL Toll free on 0800-221 100
<br><br>

<i style="color:gray">
  This is an automated message to inform you that this email address is not monitored.
  Please do not respond to this email. Any replies sent to this address will not be received or attended to.

  If you require assistance or have inquiries, please direct them to the appropriate contact person or department.
  You can find the relevant contact information on our website or in previous communications.
</i>
