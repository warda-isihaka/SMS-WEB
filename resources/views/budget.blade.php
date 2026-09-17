<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sherehe Management System - Budget</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>
<body class="bg-white p-8 font-sans">

  

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ url('/dashboard') }}" class="text-2xl font-bold text-gray-800 hover:text-amber-800">&larr;</a>
            <h1 class="text-2xl font-black tracking-wide text-gray-900">SHEREHE MANAGEMENT SYSTEM</h1>
            <div></div>
        </div>


        <!-- Form for Budget Operations -->
        <form id="budgetForm" action="{{ route('budget.index') }}" method="POST">
            @csrf

            <!-- Table 1: SMS Budget -->
            <div class="w-full max-w-md mb-4">
                <table class="w-full border-collapse border border-gray-300 text-left text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-300">
                            <th class="p-2 border-r border-gray-300 w-10 text-center delete-column hidden">Select</th>
                            <th class="p-2 border-r border-gray-300 font-bold text-gray-700">NEEDS</th>
                            <th class="p-2 font-bold text-gray-700">AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody id="needsTableBody" class="divide-y divide-gray-200">
                        @forelse($needs ?? [] as $need)
                            <tr data-amount="{{ $need->amount }}">
                                <td class="p-2 border-r border-gray-300 text-center delete-column hidden">
                                    <input type="checkbox" name="selected_items[]" value="{{ $need->id }}" class="rounded text-amber-800 focus:ring-amber-800">
                                </td>
                                <td class="p-2 border-r border-gray-300">{{ $need->name }}</td>
                                <td class="p-2">{{ number_format($need->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="2" class="p-2 text-center text-gray-400 italic">No needs added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <!-- Dynamic Input Row for Adding Needs -->
                        <tr id="inputRow" class="hidden bg-amber-50 border-t border-gray-300">
                            <td class="p-2 border-r border-gray-300 delete-column hidden"></td>
                            <td class="p-2 border-r border-gray-300">
                                <input type="text" id="newNeedName" placeholder="Enter need name..." class="w-full border border-gray-300 p-1 text-sm rounded focus:outline-none focus:border-amber-800">
                            </td>
                            <td class="p-2 flex items-center space-x-2">
                                <input type="number" id="newNeedAmount" placeholder="Amount..." class="w-full border border-gray-300 p-1 text-sm rounded focus:outline-none focus:border-amber-800">
                                <button type="button" onclick="saveNewNeed()" class="bg-amber-800 text-white px-3 py-1 rounded text-xs font-bold hover:bg-amber-900">
                                    Add
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br>

            <!-- Action Buttons -->
             @if(Auth::check() && Auth::user()->isAccountant())
            <div class="flex items-center space-x-6 mb-6">
                <button type="button" onclick="toggleAddRow()" class="flex items-center space-x-2 text-sm font-medium text-gray-800 hover:text-amber-800">
                    <span class="bg-amber-800 text-white w-5 h-5 flex items-center justify-center font-bold text-xs">+</span>
                    <span>Add needs</span>
                </button>
                <button type="button" id="removeNeedsBtn" onclick="toggleDeleteMode()" class="flex items-center space-x-2 text-sm font-medium text-gray-800 hover:text-amber-800">
                    <span id="removeIcon" class="bg-amber-800 text-white w-5 h-5 flex items-center justify-center font-bold text-xs">-</span>
                    <span id="removeBtnText">Remove needs</span>
                </button>
                @endif
            </div>

            <!-- Delete Action Area -->
            <div id="deleteActionArea" class="hidden mb-8">
                <button type="button" onclick="deleteSelectedRows()" class="bg-red-600 text-white px-4 py-1.5 rounded text-xs font-bold hover:bg-red-700 shadow-sm">
                    Delete Selected
                </button>
            </div><br>
        </form>

       <!-- Table 2: Financial Summary -->
<div class="w-full max-w-lg bg-white rounded shadow-sm overflow-hidden">
    <table class="w-full border-collapse border border-gray-300 text-left text-xs font-bold">
        <thead>
            <tr class="bg-gray-100 border-b border-gray-300">
                <th class="p-2 border-r border-gray-300 text-gray-800">TOTAL NEEDS</th>
                <th class="p-2 border-r border-gray-300 text-gray-800">TOTAL MONEY</th>
                <th class="p-2 text-gray-800">AVAILABLE MONEY</th>
            </tr>
        </thead>
        <tbody>
            <tr class="h-10">
                <!-- Total Needs Count -->
                <td class="p-2 border-r border-gray-300 text-amber-800" id="totalNeedsCount">
                    {{ isset($needs) ? $needs->count() : 0 }}
                </td>

                <!-- Total Money for Needs -->
                <td class="p-2 border-r border-gray-300" id="totalNeedsMoney">
                    {{ number_format($totalNeedsAmount ?? 0, 2) }}
                </td>

                <!-- AVAILABLE MONEY FROM DATABASE DIRECTLY -->
                <td class="p-2 {{ ($availableMoney ?? 0) < 0 ? 'text-red-600' : 'text-green-600' }}">
                    {{ number_format($availableMoney ?? 0, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

    <script>
    // Fetch base values from backend DOM attributes
    const totalMoneyPaid = parseFloat(document.getElementById('totalMoneyPaid').getAttribute('data-total-money')) || 0;

    // Recalculates needs count and total money for needs only
    function updateSummary() {
        const tbody = document.getElementById('needsTableBody');
        const rows = tbody.querySelectorAll('tr:not(#emptyRow)');
        
        // 1. Update total needs count
        const needsCount = rows.length;
        document.getElementById('totalNeedsCount').innerText = needsCount;

        // 2. Calculate total expense sum from row attributes
        let totalNeedsAmount = 0;
        rows.forEach(row => {
            const amount = parseFloat(row.getAttribute('data-amount')) || 0;
            totalNeedsAmount += amount;
        });

        // 3. Display TOTAL MONEY for Needs
        document.getElementById('totalNeedsMoney').innerText = totalNeedsAmount.toLocaleString('en-US', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
        });

    }

    // Toggle add input row visibility
    function toggleAddRow() {
        document.getElementById('inputRow').classList.toggle('hidden');
    }

    // Toggle checkbox selection mode and update button state
    function toggleDeleteMode(forceClose = false) {
        const deleteCols = document.querySelectorAll('.delete-column');
        const deleteBtnArea = document.getElementById('deleteActionArea');
        const removeBtnText = document.getElementById('removeBtnText');
        const removeIcon = document.getElementById('removeIcon');

        if (forceClose) {
            deleteCols.forEach(col => col.classList.add('hidden'));
            deleteBtnArea.classList.add('hidden');
            removeBtnText.innerText = "Remove needs";
            removeIcon.innerText = "-";
            return;
        }

        const isHidden = deleteBtnArea.classList.contains('hidden');
        
        deleteCols.forEach(col => col.classList.toggle('hidden'));
        deleteBtnArea.classList.toggle('hidden');

        if (isHidden) {
            removeBtnText.innerText = "Cancel";
            removeIcon.innerText = "✕";
        } else {
            removeBtnText.innerText = "Remove needs";
            removeIcon.innerText = "-";
        }
    }

    // Append a new row dynamically to the DOM
    function saveNewNeed() {
        const nameInput = document.getElementById('newNeedName');
        const amountInput = document.getElementById('newNeedAmount');

        if (nameInput.value.trim() === '' || amountInput.value.trim() === '') {
            alert('Please fill in both need name and amount!');
            return;
        }

        const tbody = document.getElementById('needsTableBody');
        
        const emptyRow = document.getElementById('emptyRow');
        if (emptyRow) {
            emptyRow.remove();
        }

        const newRow = document.createElement('tr');
        const amountVal = parseFloat(amountInput.value);
        const isDeleteMode = !document.querySelector('.delete-column').classList.contains('hidden');

        newRow.setAttribute('data-amount', amountVal);
        newRow.innerHTML = `
            <td class="p-2 border-r border-gray-300 text-center delete-column ${isDeleteMode ? '' : 'hidden'}">
                <input type="checkbox" name="selected_items[]" class="rounded text-amber-800 focus:ring-amber-800">
            </td>
            <td class="p-2 border-r border-gray-300">${nameInput.value}</td>
            <td class="p-2">${amountVal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        `;

        tbody.appendChild(newRow);

        nameInput.value = '';
        amountInput.value = '';
        document.getElementById('inputRow').classList.add('hidden');

        updateSummary();
    }

    // Remove marked items and automatically reset UI back to default
    function deleteSelectedRows() {
        const tbody = document.getElementById('needsTableBody');
        const checkboxes = tbody.querySelectorAll('input[type="checkbox"]:checked');

        if (checkboxes.length === 0) {
            alert('Please select at least one item to delete!');
            return;
        }

        checkboxes.forEach(cb => {
            cb.closest('tr').remove();
        });

        updateSummary();
        toggleDeleteMode(true);
    }

    // Initialize state on DOM load
    document.addEventListener('DOMContentLoaded', updateSummary);
</script>
</body>
</html>