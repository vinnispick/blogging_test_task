# Coding Standards: PHP 8.1+ Strict Mode

## Language Safety
- **Strict Types:** Every file must begin with `declare(strict_types=1);`.
- **Typing:** Avoid `mixed`. Use Union Types or specific scalars.
- **Return Types:** Mandatory for every method (use `void` or `never` if applicable).

## Modern PHP Features
- Use `readonly` properties for Value Objects and Services.
- Use `Constructor Promotion` for cleaner classes.
- Use `match()` instead of `switch()` where possible.
- Use `Enums` for fixed sets of data (e.g., Article Status).

## Formatting (PSR-12)
- Follow **PSR-12** strictly.
- Use `camelCase` for methods and properties.
- Use `PascalCase` for Classes and Interfaces.
- Logic-less templates: Do not perform complex calculations or DB queries inside Smarty `.tpl` files.