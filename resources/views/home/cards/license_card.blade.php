<style>
    .card2 {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}
</style>

<div class="card2">
    <h2>Driving Licence</h2>
    <p><strong>Full Name:</strong> {{ $data->name }}</p>
    <p><strong>License Number:</strong> {{ $data->license_number }}</p>
    <p><strong>Vehicle Type:</strong> {{ $data->vehicle_type }}</p>
    <p><strong>Issue Date:</strong> {{ $data->issue_date }}</p>
</div>
