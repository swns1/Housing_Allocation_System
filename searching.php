<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Housing Offers</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="homepage-style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div class="main">
    <div class="navbar">
      <div class="icon">
        <h2 class="logo">Neighborly</h2>
      </div>

      <div class="menu">
        <ul>
          <li><a href="#">HOME</a></li>
          <li><a href="#">MY PROFILE</a></li>
          <li><a href="searching.php">HOUSING OFFERS</a></li>
          <li><a href="#">ABOUT</a></li>
        </ul>
      </div>

      <div class="logout">  <a href="#"> <button class="btn">LOGOUT</button></a>
      </div>

    </div>

  <table id="housingTable" class="display">
    <thead>
      <tr>
        <th>Housing ID</th>
        <th>Property Type</th>
        <th>Price Range (PHP)</th>
        <th>Location</th>
        <th>Size (sqm)</th>
        <th>Eligible Family Size</th>
        <th>Location Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Apartment</td>
        <td>200,000 - 400,000</td>
        <td>Metro Manila, Quezon City</td>
        <td>32</td>
        <td>1-2 persons</td>
        <td>Located near major universities, shopping malls, and MRT stations for easy commuting.</td>
        <td><button onclick="buyHousing('1')">Buy</button></td>
      </tr>
      <tr>
        <td>2</td>
        <td>Residential Lot</td>
        <td>300,000 - 600,000</td>
        <td>Cavite, Dasmariñas City</td>
        <td>50</td>
        <td>N/A (Lot only)</td>
        <td>Situated in a gated community, close to schools, hospitals, and public markets.</td>
        <td><button onclick="buyHousing('2')">Buy</button></td>
      </tr>
      <tr>
        <td>3</td>
        <td>Condo</td>
        <td>600,000 - 1,000,000</td>
        <td>Metro Manila, Makati City</td>
        <td>35</td>
        <td>1-2 persons</td>
        <td>Walking distance to business districts, parks, and upscale restaurants.</td>
        <td><button onclick="buyHousing('3')">Buy</button></td>
      </tr>
      <tr>
        <td>4</td>
        <td>House and Lot</td>
        <td>800,000 - 1,000,000</td>
        <td>Laguna, Sta. Rosa City</td>
        <td>60</td>
        <td>3-4 persons</td>
        <td>Located in a suburban area near industrial zones, schools, and commercial establishments.</td>
        <td><button onclick="buyHousing('4')">Buy</button></td>
      </tr>
      <tr>
        <td>5</td>
        <td>Apartment</td>
        <td>250,000 - 500,000</td>
        <td>Pampanga, Angeles City</td>
        <td>40</td>
        <td>2-3 persons</td>
        <td>Close to Clark Freeport Zone, SM City Clark, and Angeles University Foundation.</td>
        <td><button onclick="buyHousing('5')">Buy</button></td>
      </tr>
      <tr>
        <td>6</td>
        <td>Commercial</td>
        <td>500,000 - 1,000,000</td>
        <td>Bulacan, Malolos City</td>
        <td>70</td>
        <td>N/A (Commercial)</td>
        <td>Strategically located near public markets, transportation hubs, and schools.</td>
        <td><button onclick="buyHousing('6')">Buy</button></td>
      </tr>
      <tr>
        <td>7</td>
        <td>Residential Lot</td>
        <td>400,000 - 700,000</td>
        <td>Rizal, Antipolo City</td>
        <td>80</td>
        <td>N/A (Lot only)</td>
        <td>Overlooks the Metro Manila skyline; near churches, resorts, and eco-tourism sites.</td>
        <td><button onclick="buyHousing('7')">Buy</button></td>
      </tr>
      <tr>
        <td>8</td>
        <td>House and Lot</td>
        <td>600,000 - 900,000</td>
        <td>Batangas, Lipa City</td>
        <td>65</td>
        <td>3-4 persons</td>
        <td>Located in a peaceful community near Lipa Cathedral and SM City Lipa.</td>
        <td><button onclick="buyHousing('8')">Buy</button></td>
      </tr>
      <tr>
        <td>9</td>
        <td>Condo</td>
        <td>700,000 - 1,000,000</td>
        <td>Metro Manila, Taguig City</td>
        <td>30</td>
        <td>1 person</td>
        <td>Situated in Bonifacio Global City, near high-end malls and multinational offices.</td>
        <td><button onclick="buyHousing('9')">Buy</button></td>
      </tr>
      <tr>
        <td>10</td>
        <td>Residential Lot</td>
        <td>200,000 - 300,000</td>
        <td>Ilocos Norte, Laoag City</td>
        <td>100</td>
        <td>N/A (Lot only)</td>
        <td>Located in a quiet area near government offices and cultural landmarks.</td>
        <td><button onclick="buyHousing('10')">Buy</button></td>
      </tr>
    </tbody>
  </table>

  <script>
    $(document).ready(function() {
      $('#housingTable').DataTable({
        pageLength: 5,
        searching: true,
        lengthChange: false
      });
    });

    function buyHousing(housingID) {
      alert(`You selected Housing ID: ${housingID}`);
      //add action here for redirecting to application page (no. 3)
    }

  </script>
</body>
</html>
