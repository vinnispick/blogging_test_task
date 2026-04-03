# Architecture Manifesto: Action-Domain-Responder (ADR)

## Core Pattern
We strictly follow the **Action-Domain-Responder** pattern to maintain a "No-Framework" clean architecture.

### 1. Actions (The Entry Point)
- **Responsibility:** Handle HTTP Requests.
- **Constraints:**
    - Must be slim.
    - Extract data from `$_GET/$_POST` and pass it to a Domain Service.
    - Call the Responder to render the view.
    - **No Business Logic allowed here.**

### 2. Domain (The Brain)
- **Responsibility:** Business logic, validation, and data processing.
- **Constraints:**
    - Must be agnostic of the delivery mechanism (Web/CLI).
    - No direct access to superglobals.
    - Uses Repositories for data persistence.

### 3. Responder (The UI)
- **Responsibility:** Bridge to the Smarty Template Engine.
- **Constraints:**
    - Injects data into `.tpl` files.
    - Handles HTTP headers and status codes.

### 4. Entities (The Data Model)
- **Responsibility:** Represent the domain data with high type safety.
- **Constraints:**
    - Use PHP 8.1+ `readonly` classes for immutability.
    - Mandatory strict typing for all properties.
    - No direct database access or logic inside Entities.
    - Use `Constructor Promotion` for cleaner code.
    - Entities are "pretty-coded": they focus on clarity and predictability.

### 5. Dependency Injection
- Manual DI Container (`Container.php`) is required.
- **Rule:** Never use the `new` keyword for Services or Repositories inside a class. Inject them via the `__construct`.