<section id="trading-signals">
  <h2 class="text-2xl font-semibold mb-4">Trading Signals</h2>
  <div id="trading-signals-data" class="text-sm space-y-2"></div>

  <script>
    const options = {
      method: 'GET',
      headers: {
        accept: 'application/json',
        'x-api-key': '{{ config("services.tokenmetrics.key") }}'
      }
    };

    fetch('https://api.tokenmetrics.com/v2/trading-signals?limit=50&page=1', options)
      .then(res => {
        if (!res.ok) throw new Error(`HTTP error! Status: ${res.status}`);
        return res.json();
      })
      .then(data => {
        const container = document.getElementById('trading-signals-data');
        container.innerHTML = ''; // Clear existing content

        const signals = (data?.data || []).filter(s => s.TRADING_SIGNAL !== 0);

        // Sort by CONFIDENCE descending
        //signals.sort((a, b) => (b.CONFIDENCE || 0) - (a.CONFIDENCE || 0));

        signals.slice(0, 5).forEach(signal => {
          const date = new Date(signal.DATE).toLocaleDateString();
          const confidence = signal.CONFIDENCE ? `${signal.CONFIDENCE}%` : 'N/A';

          let signalType = 'Neutral';
          let badgeClass = 'bg-gray-300 text-gray-800';
          if (signal.TRADING_SIGNAL === 1) {
            signalType = 'Buy';
            badgeClass = 'bg-green-500 text-white';
          } else if (signal.TRADING_SIGNAL === -1) {
            signalType = 'Sell';
            badgeClass = 'bg-red-500 text-white';
          }

          const item = document.createElement('div');
          item.className = 'p-3 border rounded shadow-sm bg-white dark:bg-gray-800';

          item.innerHTML = `
            <div class="flex justify-between items-center">
              <strong>${signal.TOKEN_NAME}</strong>
              <span class="px-2 py-1 text-xs rounded ${badgeClass}">${signalType}</span>
            </div>
            <div class="text-gray-600 dark:text-gray-400">
              Symbol: <span class="font-medium">${signal.TOKEN_SYMBOL}</span><br>
              Confidence: <span class="font-medium">${confidence}</span><br>
              Date: ${date}
            </div>
          `;

          container.appendChild(item);
        });

        if (signals.length === 0) {
          container.innerHTML = '<p>No buy/sell signals found.</p>';
        }
      })
      .catch(error => {
        console.error('Error fetching trading signals:', error);
        document.getElementById('trading-signals-data').innerHTML = '<p class="text-red-600">Failed to load trading signals.</p>';
      });
  </script>
</section>
