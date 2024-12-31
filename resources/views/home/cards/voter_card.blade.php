<style>
    .card1 {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}
</style>

<div class="card1">
    <h2>Voter Card</h2>
    <p><strong>Full Name:</strong> {{ $data->name }}</p>
    <p><strong>Voter Number:</strong> {{ $data->voter_number }}</p>
    <p><strong>Issue Date:</strong> {{ $data->issue_date }}</p>
    <p><strong>Address:</strong> {{ $data->address }}</p>
</div>
