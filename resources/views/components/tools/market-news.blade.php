<section id="market-news">
  <h2 class="text-2xl font-semibold mb-4">Market News</h2>
  <div id="market-news-list" class="space-y-2 text-sm"></div>

  <script>
    fetch('https://finnhub.io/api/v1/news?category=general&token={{ config('services.finnhub.key') }}')
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('market-news-list');
        data.slice(0, 5).forEach(article => {
          const link = document.createElement('a');
          link.href = article.url;
          link.textContent = article.headline;
          link.className = 'block text-blue-600 hover:underline';
          link.target = '_blank';
          container.appendChild(link);
        });
      })
      .catch(error => {
        console.error('Error fetching news:', error);
      });
  </script>
</section>
