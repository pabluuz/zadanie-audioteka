# Audioteka: zadanie rekrutacyjne

## 🏆 Rozwiązanie

Wybrałem zadania oznaczone tickiem (✓). Chciałem spróbować sił w implementacji zadania nr 2, ponieważ jest to fajny problem, który może często występować
w rozwiązaniu asynchronicznym, natomiast zadanie nr 3 wydawało mi się, że da się bardzo elegancko rozwiązać za pomocą Gedmo\Timestampable  
Zadanie nr 4 jest dodaniem end-pointa delete (PUT) i obsługą go.

Utworzyłem pomocniczą kolekcję postmana, łatwiej mi się tak debugowało (np wysyłanie szybko requesty, usuwanie
ostatniego pliku z koszyka itp). Wrzucam tą kolekcję do [Audioteka.postman_collection.json](./Audioteka.postman_collection.json).

### 💡 Chcemy móc dodawać do koszyka ten sam produkt kilka razy, o ile nie zostanie przekroczony limit sztuk produktów. 
Moim zdaniem jednym z podejść jest utworzenie encji relacyjnej, gdzie będzie składowana ilość produktów

### ✓ Limit koszyka nie zawsze działa. Wprawdzie, gdy dodajemy czwarty produkt do koszyka to dostajemy komunikat `Cart is full.`, ale pomimo tego i tak niektóre koszyki mają po cztery produkty: 
Bug ten pojawił się, ponieważ limit jest sprawdzany zanim coś trafi do kolejki, natomiast może w kolejce już coś czekać na dodanie, lub dwie takie operacje mogą wykonywać się na raz. 
Dodałem w CartRepository->addProduct() proste zabezpieczenie. 
W postmanie zamieściłem przykład jak zaspamować system, tak żeby to wywołać (wpierw trzeba usunąć z CartRepo zabezpieczenie).

### ✓ Najnowsze (ostatnio dodane) produkty powinny być dostępne na początkowych stronach listy produktów:  
Dodałem order (created DESC) do repo produktów. Trochę kusiło mnie, żeby zmienić uuid na id (ponieważ póki co YAGNI, a id pozwala na łatwiejsze sortowanie),
ale ostatecznie założyłem, że mogą być inne serwisy rozmawiające z tym.

### ✓ Musimy mieć możliwość edycji produktów. Czasami w nazwach są literówki, innym razem cena jest nieaktualna:  
Dodałem end-point do edycji produktu (crUd). Dodałem też obsługę pod spodem do kolejki i repo.

### Refaktor:

Kontroler Cart/AddProductController, Catalog/AddController:
Można przenieść walidację do walidatorów.
Dodatkowo między Catalog/AddController i Catalog/EditController jest trochę sucho 🏜️(DRY)

Repo CartRepository:
Warto by było zwracać coś też przy usuwaniu z wózka, bo póki co mamy sytuację taką, że dostajemy http 200~ nawet gdy
nie jest to prawda. 

Encja Product:  
priceAmount -> price. Słowo amount było troszkę mylne. Może to trochę O z solida naruszać, ale zakładam, że 
jesteśmy na etapie wczesnego alpha :)
 
## Instalacja

Do uruchomienia wymagany jest `docker` i `docker-compose`

1. Zbuduj obrazy dockera `docker-compose build`
1. Zainstaluj zależności `docker-compose run --rm php composer install`.
1. Zainicjalizuj bazę danych `docker-compose run --rm php php bin/console doctrine:schema:create`.
1. Zainicjalizuj kolejkę Messengera `docker-compose run --rm php php bin/console messenger:setup-transports`.
1. Uruchom serwis za pomocą `docker-compose up -d`.

Jeśli wszystko poszło dobrze, serwis powinien być dostępny pod adresem 
[https://localhost](https://localhost).

Przykładowe zapytania (jak komunikować się z serwisem) znajdziesz w [requests.http](./requests.http).

Testy uruchamia polecenie `docker-compose run --rm php php bin/phpunit`

## Oryginalne wymagania dotyczące serwisu

Serwis realizuje obsługę katalogu produktów oraz koszyka. Klient serwisu powinien móc:

* dodać produkt do katalogu,
* usunąć produkt z katalogu,
* wyświetlić produkty z katalogu jako stronicowaną listę o co najwyżej 3 produktach na stronie,
* utworzyć koszyk,
* dodać produkt do koszyka, przy czym koszyk może zawierać maksymalnie 3 produkty,
* usunąć produkt z koszyka,
* wyświetlić produkty w koszyku, wraz z ich całkowitą wartością.

Kod, który masz przed sobą, stara się implementować te wymagania z pomocą `Symfony 6.0`.

## Zadanie

Użytkownicy i testerzy serwisu zgłosili następujące problemy i prośby:

* Chcemy móc dodawać do koszyka ten sam produkt kilka razy, o ile nie zostanie przekroczony limit sztuk produktów. Teraz to nie działa.
* Limit koszyka nie zawsze działa. Wprawdzie, gdy dodajemy czwarty produkt do koszyka to dostajemy komunikat `Cart is full.`, ale pomimo tego i tak niektóre koszyki mają po cztery produkty. 
* Najnowsze (ostatnio dodane) produkty powinny być dostępne na początkowych stronach listy produktów. 
* Musimy mieć możliwość edycji produktów. Czasami w nazwach są literówki, innym razem cena jest nieaktualna.

Prosimy o naprawienie / implementację.

Ps. prawdziwym celem zadania jest oczywiście kawałek kodu, który możemy ocenić, a potem porozmawiać o nim w czasie interview "twarzą w twarz". 
Wybierz, które i ile z zadań chcesz zaprezentować. Możesz zrobić dwa, które wydają ci się trudniejsze / ciekawsze. Możesz zrobić więcej.
To Twoja okazja na pokazanie umiejętności, więc jeśli uważasz, że w kodzie jest coś nie tak, widzisz więcej błędów, coś powinno być zaimplementowane
inaczej, możesz do listy zadań dodać opcjonalny refactoring, albo krótko wynotować swoje spostrzeżenia. 
