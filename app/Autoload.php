<?php

// Ten plik ładuje wszystkie niezbędne pliki PHP wymagane do działania aplikacji.
// Używa funkcji require_once, aby upewnić się, że każdy plik jest załadowany tylko raz.
// Ładuje kontrolery, modele, usługi, repozytoria i inne kluczowe komponenty aplikacji.
// Dzięki temu plikowi, wszystkie klasy i funkcje są dostępne w całej aplikacji, co umożliwia ich użycie bez konieczności wielokrotnego ładowania tych samych plików.

require_once __DIR__ . '/controllers/GalleryController.php';
require_once __DIR__ . '/controllers/ErrorController.php';
require_once __DIR__ . '/controllers/RememberController.php';
require_once __DIR__ . '/models/Image.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/services/ImageService.php';
require_once __DIR__ . '/services/FileValidator.php';
require_once __DIR__ . '/services/ImageProcessor.php';
require_once __DIR__ . '/services/GalleryService.php';
require_once __DIR__ . '/services/RememberService.php';
require_once __DIR__ . '/repositories/ImageRepository.php';
require_once __DIR__ . '/core/DataBase.php';