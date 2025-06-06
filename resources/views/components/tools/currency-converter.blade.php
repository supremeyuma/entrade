<section id="currency-converter" class="my-10">
  <h2 class="text-2xl font-semibold mb-4">Currency Converter</h2>
  <div class="grid md:grid-cols-3 gap-4 text-sm">
    <select id="cc-from" placeholder="From" class="border p-2 rounded w-full">
      <option value="">From currency...</option>
    </select>
    <select id="cc-to" placeholder="To" class="border p-2 rounded w-full">
      <option value="">To currency...</option>
    </select>
    <input id="cc-amount" type="number" placeholder="Amount" class="border p-2 rounded w-full">
  </div>
  <button onclick="convertCurrency()" class="mt-3 bg-blue-600 text-white px-4 py-2 rounded">
    Convert
  </button>
  <p id="cc-result" class="mt-2 font-medium text-green-600"></p>
</section>


<script>
const currencyList = [
  { code: 'USD', name: 'United States Dollar' },
  { code: 'EUR', name: 'Euro' },
  { code: 'GBP', name: 'British Pound Sterling' },
  { code: 'NGN', name: 'Nigerian Naira' },
  { code: 'KES', name: 'Kenyan Shilling' },
  { code: 'GHS', name: 'Ghanaian Cedi' },
  { code: 'ZAR', name: 'South African Rand' },
  { code: 'JPY', name: 'Japanese Yen' },
  { code: 'CNY', name: 'Chinese Yuan' },
  { code: 'INR', name: 'Indian Rupee' },
  { code: 'CAD', name: 'Canadian Dollar' },
  { code: 'AUD', name: 'Australian Dollar' },
  { code: 'CHF', name: 'Swiss Franc' },
  { code: 'BRL', name: 'Brazilian Real' },
  { code: 'MXN', name: 'Mexican Peso' },
  { code: 'SEK', name: 'Swedish Krona' },
  { code: 'NOK', name: 'Norwegian Krone' },
  { code: 'DKK', name: 'Danish Krone' },
  { code: 'AED', name: 'United Arab Emirates Dirham' },
  { code: 'SAR', name: 'Saudi Riyal' },
  { code: 'EGP', name: 'Egyptian Pound' },
  { code: 'PKR', name: 'Pakistani Rupee' },
  { code: 'BDT', name: 'Bangladeshi Taka' },
  { code: 'TRY', name: 'Turkish Lira' },
  { code: 'THB', name: 'Thai Baht' }
];
</script>


<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

<script>
function populateCurrencyDropdowns() {
  const fromSelect = document.getElementById('cc-from');
  const toSelect = document.getElementById('cc-to');

  currencyList.forEach(currency => {
    const optionFrom = document.createElement('option');
    optionFrom.value = currency.code;
    optionFrom.textContent = `${currency.name} (${currency.code})`;
    fromSelect.appendChild(optionFrom);

    const optionTo = optionFrom.cloneNode(true);
    toSelect.appendChild(optionTo);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  populateCurrencyDropdowns();

  new TomSelect("#cc-from", { create: false, maxItems: 1 });
  new TomSelect("#cc-to", { create: false, maxItems: 1 });
});
</script>

<script>
function convertCurrency() {
  const from = document.getElementById('cc-from').value;
  const to = document.getElementById('cc-to').value;
  const amount = parseFloat(document.getElementById('cc-amount').value);
  const resultEl = document.getElementById('cc-result');
  

  if (!from || !to || isNaN(amount) || amount <= 0) {
    resultEl.textContent = "Please select both currencies and enter a valid amount.";
    resultEl.classList.remove("text-green-600");
    resultEl.classList.add("text-red-600");
    return;
  }

  fetch(`https://api.twelvedata.com/exchange_rate?symbol=${from}/${to}&apikey={{ config('services.twelvedata.key') }}`)
    .then(res => res.json())
    .then(data => {
      const rate = parseFloat(data.rate);
      if (!isNaN(rate)) {
        const converted = amount * rate;
        resultEl.textContent = `${amount} ${from} = ${converted.toFixed(2)} ${to}`;
        resultEl.classList.remove("text-red-600");
        resultEl.classList.add("text-green-600");
      } else {
        resultEl.textContent = "Could not get exchange rate.";
        resultEl.classList.add("text-red-600");
      }
    })
    .catch(err => {
      console.error(err);
      resultEl.textContent = "Error fetching conversion rate.";
      resultEl.classList.add("text-red-600");
    });
}

// Automatically convert when the amount input is blurred
document.addEventListener('DOMContentLoaded', () => {
  const amountInput = document.getElementById('cc-amount');
  amountInput.addEventListener('blur', convertCurrency);

  // Optional: also convert when currency selections change
  document.getElementById('cc-from').addEventListener('change', convertCurrency);
  document.getElementById('cc-to').addEventListener('change', convertCurrency);
});
</script>

