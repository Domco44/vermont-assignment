# Vermont Eshop – Administrácia produktov

Tento projekt bol vyvinutý pre firmu **Vermont** v rámci zadania výberového konania.  
Cieľom bolo vytvoriť jednoduchú a bezpečnú administráciu produktov eshopu, ktorá umožňuje efektívnu správu produktov a ich lokalizovaných údajov.

## Zadanie projektu

Požiadavky zadania:

- Prístup do administrácie len po prihlásení.
- Administrácia obsahuje správu produktov (CRUD), pričom každý produkt má:
  - ID
  - Meno
  - Popis
  - Unikátny hash (16-znakový string)
  - Priradené kategórie (produkt môže patriť do viacerých kategórií)
- Kategórie (správu kategórií nie je potrebné implementovať, stačí statický zoznam z databázy).
  - ID
  - Meno
- Po vytvorení každého nového produktu je administrátor informovaný emailom (`admin@test.com`) po **15 minútach**.
- Aplikácia je **dvojjazyčná** (slovenčina + angličtina).

---

## Prehľad projektu

Táto aplikácia umožňuje:

- Administrátorom spravovať produkty vrátane lokalizovaných mien a popisov.
- Priradiť produkty ku kategóriám.
- Automatizované odosielanie informačných emailov administrátorovi po vytvorení produktu (s oneskorením 15 minút cez Laravel queue).
- Zobraziť produkty na jednoduchom eshope s možnosťou filtrovania podľa kategórií.
- Prepnúť jazyk používateľa medzi slovenským a anglickým.

---

## Funkcie

### Správa produktov (CRUD)

- ID, hash, meno, popis, image URL, kategórie
- Hash sa generuje automaticky pri vytvorení produktu, ak nie je zadaný používateľom.
- Formuláre sú lokalizované podľa jazyka používateľa.
- Soft delete implementovaný pre produkty, aj kategórie (možnosť obnovenia).

### Kategórie

- Každá kategória má ID a lokalizované meno.
- Priradenie produktov ku kategóriám je možné cez multiselect.
- V administrácii sa kategórie identifikujú podľa ID.
- Soft delete implementovaný pre kategórie.

### Emailové notifikácie

- Posielané emaily po vytvorení produktu sú oneskorené o 15 minút.
- Mail obsahuje informácie o produkte a link na jeho zobrazenie v administrácii.
- Testovanie lokálne pomocou **Mailpit**.

#### Konfiguračné premenné

```bash
MAIL_ADMIN_ADDRESS=admin@test.com
MAIL_EMAIL_DELAY_MINUTES=15
```

### Autentifikácia

- Prístup do `/admin` sekcie je povolený len prihláseným používateľom s oprávnením.
- Laravel Breeze poskytuje login a registráciu.

### Lokalizácia

- Podporované jazyky: `sk`, `en`
- Jazyk je prepínateľný v administrácii aj na eshope.
- Preklady sú uložené v JSON súboroch.

### Verejný eshop

- Jednoduché zobrazenie produktov, filtrovanie podľa kategórií.

---

## Technológie

- Laravel 12
- PHP 8.2+
- MySQL
- Tailwind CSS
- Mailpit (lokálne testovanie emailov)
- Laravel Queue (database driver)

---

## Architektúra

## Databázový model

### Tabuľky a vzťahy

#### products
- Hlavná tabuľka produktov.
- Podporuje soft delete.
- Vzťahy:
    - Má viacero prekladov v `product_translations`.
    - Môže byť priradený do viacerých kategórií cez pivot tabuľku `category_product`.

#### categories
- Tabuľka kategórií.
- Podporuje soft delete.
- Vzťahy:
    - Má viacero prekladov v `category_translations`.
    - Môže byť priradená k viacerým produktom cez pivot tabuľku `category_product`.

#### product_translations
- Lokalizované údaje produktov.
- Podporuje soft delete.
- Vzťahy:
    - Patrí k jednému produktu (`product_id`).

#### category_translations
- Lokalizované názvy kategórií.
- Podporuje soft delete.
- Vzťahy:
    - Patrí k jednej kategórii (`category_id`).

#### category_product
- Pivot tabuľka pre vzťah *m:n* medzi produktmi a kategóriami.
- Vzťahy:
    - Priraďuje produkty ku kategóriám a naopak.

### Vzťahy v skratke
- **products 1:N product_translations**
- **categories 1:N category_translations**
- **products M:N categories** cez `category_product`

### Hlavné rozhodnutia

- JSON lokalizácia umožňuje jednoduchú rozšíriteľnosť jazykov.
- Emailové notifikácie sú realizované cez DB queue s oneskorením.
- Hash produktov generovaný na úrovni modelu pre garanciu jedinečnosti.

---

## Inštalácia

### Požiadavky

- PHP 8.2+
- Composer
- MySQL
- Node.js a NPM
- Mailpit pre testovanie emailov

### Setup

Aplikácia obsahuje jednoduchých Seederov pre produkty a kategórie

```bash
php artisan migrate
php artisan db:seed
```

## Routes

### Admin

```bash
GET     /admin/products                  # zoznam produktov
GET     /admin/products/create           # formulár pre vytvorenie produktu
POST    /admin/products                  # uloženie nového produktu
GET     /admin/products/{product}/edit   # formulár pre editáciu produktu
PUT     /admin/products/{product}        # aktualizácia produktu
DELETE  /admin/products/{product}        # odstránenie produktu (soft delete)
```

### Eshop

```bash
GET /shop                                # zoznam produktov
GET /shop?category_id={id}               # filtrovanie podľa ID kategórie
```

### Lokalizácia
```bash
GET /locale/{locale}                      # prepnutie jazyka (sk / en)
```

### Dashboard
```bash
GET /dashboard                            # dashboard pre používateľa
```

## Emaily

- Event: ProductCreated
- Listener: SendProductCreatedMail implements ShouldQueue
- Mailable: ProductCreatedMail (HTML šablóna)
- Odosielané po 15 minútach cez queue
- Tlačidlo v emaile smeruje na detail produktu
- Testovanie v dev prostredí cez Mailpit

## Queue

- Použitý database queue driver (QUEUE_CONNECTION=database)
- Spustenie worker:

```bash
php artisan queue:work
```

## Bezpečnosť

- Admin sekcia chránená autentifikáciou (auth)
- CSRF ochrana povolená globálne
- Validácia všetkých formulárov
- Unikátny hash pre každý produkt
- Soft delete pre produkty aj kategórie
- Žiadne citlivé údaje v requestoch

## Jazyková podpora

- Aplikácia podporuje en a sk
- Preklady sú uložené v JSON súboroch resources/lang/en.json a resources/lang/sk.json
- Prepínanie jazyka cez route /locale/{locale}
- Všetky statické texty, tlačidlá a hlavičky sú lokalizované

## Budúce rozšírenia

- Upload obrázkov na disk alebo S3
- Plná správa kategórií
- API rozhranie s Laravel Sanctum
- Rozšírené filtrovanie a vyhľadávanie na eshope

