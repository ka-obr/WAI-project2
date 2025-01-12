<?php

return [ // zwraca tablicę konfiguracyjną połączenia do bazy danych MongoDB
    'mongo' => [ // Klucz 'mongo' zawiera konfigurację połączenia do bazy danych MongoDB
        'uri' => 'mongodb://localhost:27017/wai', // URI połączenia do MongoDB, wskazujący na lokalny serwer MongoDB na porcie 27017 oraz bazę danych 'wai'
        'username' => 'wai_web', //Nazwa do uwierzytelnienia w MongoDB
        'password' => 'w@i_w3b', //Hasło do uwierzytelnienia w MongoDB
        'database' => 'wai' // Nazwa bazy danych, do której aplikacja będzie się łączyć
    ]
];