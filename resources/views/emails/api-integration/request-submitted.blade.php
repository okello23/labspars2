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

Hello Genomics Admin,<br><br>
<b>{{ $integration_request['app_name'] }} </b>  of version: <b>{{ $integration_request['version'] }} </b>,
owned by  <b> {{$integration_request['vendor']}}</b> <br>
has successfully registered for an API integration with the Lab Spars.<br><br>

Client ID assigned to this request: <b>{{ $integration_request['client_id'] }} </b>

<br><br>
<i>Please log into the Lab Spars to approve or reject this API integration request(s)</i>
