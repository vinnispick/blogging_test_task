# 2026-04-01: Makefile Implementation

## Technical Decisions (ADR Style)

1.  **Automation Over Manual Commands:** To simplify development and avoid incorrect PHP server usage, I've implemented a **Makefile**. This provides a unified entry point for common tasks (serve, seed, compile).
2.  **Explicit Target Mapping:**
    - `serve`: Maps to the correct built-in web server command (`php -S ... -t public/`).
    - `scss-compile/watch`: Encapsulates the `npx -y sass` command to ensure styling workflow is effortless.
    - `setup`: Automates the initial project bootstrapping (Composer, .env, CSS).

## Modified/Created Files

- `Makefile` [NEW]
- `.obsidian_vault/Current_Task.md` [MODIFY] (Marked completed)

## Potential Technical Debt & Future Optimizations

- **Containerization:** For higher-level production parity, this Makefile could eventually be ported to `docker-compose`.

---
*Created by Antigravity (AI Agent).*
