<!--<section id="live-charts">
    <!--<h2 class="text-2xl font-semibold mb-4">Live Chart</h2>
    <iframe src="https://www.tradingview.com/widgetembed/?frameElementId=tradingview_0bc7c&symbol=FX:EURUSD&interval=15&hidesidetoolbar=1&symboledit=1&saveimage=1&toolbarbg=f1f3f6&studies=[]&theme=light&style=1&timezone=Etc/UTC&withdateranges=1&hideideas=1" 
        width="100%" height="500" frameborder="0" allowtransparency="true" scrolling="no">
    </iframe>-->

    <!-- TradingView Widget BEGIN -->
    <h2 class="text-2xl font-semibold mb-4">Live Chart</h2>
<!--<div class="tradingview-widget-container" style="height:100%;width:100%">
  <div class="tradingview-widget-container__widget" style="height:calc(500% - 302px);width:100%"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
  {
  "autosize": true,
  "symbol": "FX:EURUSD",
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "dark",
  "style": "1",
  "locale": "en",
  "allow_symbol_change": true,
  "support_host": "https://www.tradingview.com"
}
  </script>
</div>-->
<!-- TradingView Widget END -->

<!--</section>-->


<section id="live-charts" class="mb-8">
  <h2 class="text-2xl font-semibold mb-4">Live Chart</h2>

  <div id="tradingview-widget-container" class="relative w-full max-w-4xl mx-auto" style="padding-bottom: 56.25%; height: 0;">
    <iframe 
      id="tradingview-iframe"
      src="https://s.tradingview.com/widgetembed/?symbol=FX:EURUSD&interval=D&theme=light&style=1&locale=en&toolbarbg=f1f3f6&withdateranges=1&hideideas=1&allow_symbol_change=1" 
      style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;" 
      allowtransparency="true" 
      scrolling="no">
    </iframe>
  </div>

  <script>
    // Function to update the TradingView iframe theme dynamically
    function updateTradingViewTheme(theme) {
      const iframe = document.getElementById('tradingview-iframe');
      const baseUrl = 'https://s.tradingview.com/widgetembed/';
      const params = new URLSearchParams({
        symbol: 'FX:EURUSD',
        interval: 'D',
        theme: theme,
        style: '1',
        locale: 'en',
        toolbarbg: theme === 'dark' ? '2a2a2a' : 'f1f3f6',
        withdateranges: '1',
        hideideas: '1',
        allow_symbol_change: '1'
      });
      iframe.src = `${baseUrl}?${params.toString()}`;
    }

    // Detect initial theme (assuming dark mode toggles 'dark' class on html)
    const isDark = document.documentElement.classList.contains('dark');
    updateTradingViewTheme(isDark ? 'dark' : 'light');

    // Observe theme toggling dynamically
    const observer = new MutationObserver(() => {
      const darkMode = document.documentElement.classList.contains('dark');
      updateTradingViewTheme(darkMode ? 'dark' : 'light');
    });
    observer.observe(document.documentElement, { attributes: true });
  </script>
</section>
