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

Hello {{ $integration_request['app_name'] }} ,<br><br>

your API Integration Request with Lab Spars with Client ID <b>{{ $integration_request['client_id'] }} </b>

has been approved.
Here's your bearer token:<br><br>

<b>{{ $integration_request['bearer_token'] }}</b>
<br><br>
