<style>
    .card1 {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}
</style>

<div class="card1">
    <h2>Plus 2</h2>
    <p><strong>Full Name:</strong> {{ $data->name }}</p>
    <p><strong>Symbol Number:</strong> {{ $data->symbol_number }}</p>
    <p><strong>Passed Year:</strong> {{ $data->passed_year }}</p>
    <p><strong>GPA:</strong> {{ $data->gpa }}</p>
    <p><strong>College:</strong> {{ $data->college }}</p>
</div>
