📘 PROGRAMMING PRINCIPLES
🔹 SoC (Separation of Concerns) — Розділення відповідальності

Проєкт побудований за архітектурним шаблоном MVC (Model-View-Controller), що забезпечує чітке розділення логіки:

Models — описують структуру даних та правила валідації
Views — відповідають лише за відображення інтерфейсу
Controllers — обробляють HTTP-запити та координують роботу між моделями та представленнями

📂 Приклади:

Models:
https://github.com/vtk251zhdo/FMs-2026/tree/main/Models
Views:
https://github.com/vtk251zhdo/FMs-2026/tree/main/Views
Controllers:
https://github.com/vtk251zhdo/FMs-2026/tree/main/Controllers
🔹 Dependency Injection (Впровадження залежностей)

У проєкті використовується вбудований DI-контейнер ASP.NET Core для передачі залежностей (зокрема контексту бази даних) у контролери.

Це:

зменшує зв’язність компонентів
полегшує тестування
дозволяє змінювати реалізації без зміни логіки

📌 Доказ у коді:
Контекст VideoGamesCatalogContext ін’єктується через конструктор контролера:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Controllers/GamesController.cs#L17

🔹 DRY (Don't Repeat Yourself)

Уникається дублювання коду шляхом винесення спільних частин у повторно використовувані компоненти:

Layouts — загальна структура сайту
Partial Views — повторювані частини інтерфейсу
Validation Scripts — спільні скрипти валідації

📌 Приклади:

Layout:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Views/Shared/_Layout.cshtml
Validation partial:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Views/Shared/_ValidationScriptsPartial.cshtml
🔹 Data Annotations (Декларативна валідація)

Валідація реалізована через атрибути моделей замість ручних перевірок:

[Required]
[StringLength]
інші

Це дозволяє:

автоматично перевіряти дані через ModelState
зменшити кількість коду
підвищити читабельність

📌 Приклад:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Models/User.cs

🔹 Strongly-typed Views (Строга типізація)

У представленнях використовується директива @model, що забезпечує:

перевірку типів під час компіляції
автодоповнення (IntelliSense)
меншу кількість runtime-помилок

📌 Приклад:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Views/Games/Details.cshtml

🔹 KISS (Keep It Simple, Stupid)

Контролери реалізовані максимально просто без зайвих рівнів абстракції.

використовується прямий доступ до Entity Framework Core
відсутні надлишкові сервіси там, де вони не потрібні
код легко читається та підтримується

📌 Приклад:
https://github.com/vtk251zhdo/FMs-2026/blob/main/Controllers/GenresController.cs
