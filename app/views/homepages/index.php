<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/homepagina-style.css">
  <title>Theater Homepagina</title>
</head>
<body>
    <div class="overlay" id="overlay" style="display:none;">
    <div class="error-message" id="error-message">
      <h1 class="w3-xxlarge w3-text-black"><strong>Pagina niet beschikbaar</strong></h1>
      <p class="w3-text-black">Sorry, de site is tijdelijk niet beschikbaar vanwege onderhoud. Kom later nog eens terug.</p>
      <p class="w3-text-black">Onze excuses voor het ongemak.</p>
    </div>
  </div>
  <nav>
    <div class="logo"> <img src="/img/Theater-logo.png" id="LOGO"></div>
    <div>
      <a href="index.html">Home</a>
      <a href="../Voorstellingen/Overzicht.php">Voorstellingen</a>
      <a href="#">Contact</a>
      <a href="../Dashboard/index.php">Dashboard</a>
       <a href="../Tickets/tickets.html">Tickets</a>
      <a href="#">Login</a>
      <a href="#">Uitloggen</a>
    </div>
  </nav>
  <div class="banner">
    <div class="bannerItems">
      <a href="#"></a><button id="Banneritem1">Bekijk de nieuwste voorstellingen</button></a>
      <a href="#"><button id="Banneritem2">Nu bekijken, gelijk genieten -></button></a>
    </div>
  </div>
<section class="content-wrapper">
  <div class="voorstellingen" id="voorstellingen">
    <h2>Aankomende Voorstellingen:</h2>
    <div class="voorstelling">
      <h3>Voorstelling-De Avondval</h3>
      <p>20-06-2025 - 20:00</p>
      <img src="https://www.theaterkikker.nl/cache/een-schaduw-is-dat-waar-geen-licht-op-valt.12999/een-schaduw-is-dat-waar-geen-licht-op-valt-s1920x1080.jpg" id="IMG1">
      <a href="#"><button id="ticket-btn">Bestel tickets</button></a>
      <p id="tickets-over">Tickets: 150</p>
      <p id="Introductie">"Een spannende theateravond over het mysterie van de AvondVal."</p>
    </div>
    <div class="voorstelling">
      <h3>ComedyNight-Lachstorm</h3>
      <p>21-06-2025 - 21:00</p>
      <img src="https://www.theaterkrant.nl/wp-content/uploads/2025/03/20250304_UICF_Photography_ComediansversusComputers_Britt-Staal20-DSC06019-1024x683.jpg" id="IMG2">
      <a href="#"><button id="ticket-btn">Bestel tickets</button></a>
      <p id="tickets-over">Tickets: 120</p>
      <p id="Introductie">"Een avond vol humor met top cabarretiers."</p>
    </div>
    <div class="voorstelling">
      <h3>MuziekAvond-Jazz en meer</h3>
      <p>22-06-2025 - 19:30</p>
      <img src="https://www.theater.nl/assets/Voorstelling/Thumbnail/jazz-in-the-park-1-soul-vibes-steffen-morisson-yerry-rellum-the-legends-e-a-1024x683__ScaleMaxWidthWzQyMF0_CompressedW10.jpg" id="IMG3">
      <a href="#"><button id="ticket-btn">Bestel tickets</button></a>
      <p id="tickets-over">Tickets: 100</p>
      <p id="Introductie">"Live jazzoptredens van lokale artiesten"</p>
    </div>
      <div class="voorstelling">
      <h3>KinderAvond-De DroomBoom</h3>
      <p>23-06-2025 - 14:00</p>
      <img src="https://percossa.nl/images/jcogs_imgv1/cache/droom-scene_-_28de80_-_e474eb9b62e73892c6e6cefa806a28e0041c03f6.webp" id="IMG4">
      <a href="#"><button id="ticket-btn">Bestel tickets</button></a>
      <p id="tickets-over">Tickets: 80</p>
      <p id="Introductie">"Een magisch verhaal voor kinderen van 4 tot 10 jaar"</p>
    </div>
  </div>

  <div class="contact-box" id="contact">
    <h2>Contact Ons</h2>
    <p>Email: info@auroratheater.nl</p>
    <p>Telefoon: 06 12121212</p>
    <p>Adres: Theaterstraat 1, Utrecht</p>
  </div>
</section>


  <footer id="contact">
     <div class="logo"> <img src="/img/Theater-logo.png" id="Logo-footer"></div>
    <p>&copy; 2025 Aurora Theater. Alle rechten voorbehouden.</p>
  </footer>
  <script src="/js/homepagina.js"></script>
</body>
</html>
