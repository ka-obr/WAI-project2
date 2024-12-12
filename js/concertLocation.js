function showNearestConcert() 
{
    if(navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(determineConcertLocation, function() 
        {
            document.getElementById("concertLocation").innerText = "Nie można uzyskać dostępu do lokalizacji.";
        });
    }
    else
    {
        document.getElementById("concertLocation").innerText = "Geolokalizacja nie jest wspierana przez tę przeglądarkę.";
    }
}

const concerts = 
[
    { city: "Warszawa", lat: 52.2297, info: "Koncert w Warszawie - 15 grudnia" },
    { city: "Kraków", lat: 50.0647, info: "Koncert w Krakowie - 20 stycznia" },
    { city: "Gdańsk", lat: 54.3520, info: "Koncert w Gdańsku - 5 lutego" }
];


function determineConcertLocation(position)
{
    const userLat = position.coords.latitude;
    let nearestConcert = concerts[0];

    concerts.forEach(concert => 
    {
        if(Math.abs(userLat - concert.lat) < Math.abs(userLat - nearestConcert.lat)) 
        {
            nearestConcert = concert;
        }
    });
        
    document.getElementById("concertLocation").innerText = `Najbliższy koncert: ${nearestConcert.info}`;
}
