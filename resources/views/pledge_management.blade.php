<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Pledge - Sherehe Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #ffffff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 50px;
        }

        .title {
            font-size: 26px;
            font-weight: bold;
            color: #000;
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .table-container {
            width: 85%;
            max-width: 900px;
            background: #d1f7c4;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #b2e3a3;
            font-size: 15px;
            color: #222;
        }

        th {
            background-color: #beefa8;
            font-weight: bold;
        }

        .paid-input {
            width: 100px;
            padding: 5px 8px;
            font-size: 14px;
            border: 1.5px solid #000;
            border-radius: 4px;
            outline: none;
            background-color: #fff;
        }

        .total-row {
            font-weight: bold;
            background-color: #beefa8;
        }

        .btn-container {
            margin-top: 30px;
        }

        .btn-toggle {
            background-color: #dfb15b;
            color: #000;
            border: none;
            padding: 12px 30px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            letter-spacing: 1.5px;
        }

        .btn-toggle:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <h1 class="title">SHEREHE MANAGEMENT SYSTEM</h1>

    <div class="table-container">
        <table id="pledgeTable">
            <thead>
                <tr>
                    <th>No:</th>
                    <th>Name</th>
                    <th>Promise</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Remain</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Juma Hamisi</td>
                    <td class="promise-val">100000</td>
                    <td class="amount-val">100000</td>
                    <td class="paid-val">40000</td>
                    <td class="remain-val">0</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Amina Said</td>
                    <td class="promise-val">200000</td>
                    <td class="amount-val">200000</td>
                    <td class="paid-val">150000</td>
                    <td class="remain-val">0</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Baraka Ally</td>
                    <td class="promise-val">50000</td>
                    <td class="amount-val">50000</td>
                    <td class="paid-val">50000</td>
                    <td class="remain-val">0</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td></td>
                    <td>Total</td>
                    <td id="totalPromise">0</td>
                    <td id="totalAmount">0</td>
                    <td id="totalPaid">0</td>
                    <td id="totalRemain">0</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="btn-container">
        <button id="editBtn" class="btn-toggle" onclick="toggleEdit()">Edit</button>
    </div>

    <script>
        let isEditing = false;

        function calculateTotals() {
            let rows = document.querySelectorAll('#pledgeTable tbody tr');
            let grandPromise = 0;
            let grandAmount = 0;
            let grandPaid = 0;
            let grandRemain = 0;

            rows.forEach(row => {
                let promise = parseFloat(row.querySelector('.promise-val').innerText) || 0;
                let amount = parseFloat(row.querySelector('.amount-val').innerText) || 0;
                let paidCell = row.querySelector('.paid-val');
                let paid = 0;

                if (paidCell.querySelector('input')) {
                    paid = parseFloat(paidCell.querySelector('input').value) || 0;
                } else {
                    paid = parseFloat(paidCell.innerText) || 0;
                }

                // Remain = Amount - Paid
                let remain = amount - paid;
                row.querySelector('.remain-val').innerText = remain;

                grandPromise += promise;
                grandAmount += amount;
                grandPaid += paid;
                grandRemain += remain;
            });

            document.getElementById('totalPromise').innerText = grandPromise;
            document.getElementById('totalAmount').innerText = grandAmount;
            document.getElementById('totalPaid').innerText = grandPaid;
            document.getElementById('totalRemain').innerText = grandRemain;
        }

        function toggleEdit() {
            let btn = document.getElementById('editBtn');
            let paidCells = document.querySelectorAll('.paid-val');

            if (!isEditing) {
                paidCells.forEach(cell => {
                    let currentVal = cell.innerText;
                    cell.innerHTML = `<input type="number" class="paid-input" value="${currentVal}" oninput="calculateTotals()">`;
                });

                btn.innerText = "Update";
                isEditing = true;
            } else {
                paidCells.forEach(cell => {
                    let inputVal = cell.querySelector('input').value;
                    cell.innerText = inputVal || 0;
                });

                calculateTotals();

                btn.innerText = "Edit";
                isEditing = false;
            }
        }

        window.onload = calculateTotals;
    </script>

</body>
</html>