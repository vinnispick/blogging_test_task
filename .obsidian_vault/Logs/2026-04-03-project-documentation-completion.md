# Log: 2026-04-03 - Project Documentation Completion

## Technical Decisions Made (ADR Style)
- **Clarification**: Standardized the Docker setup instructions to reflect the automated migration process triggered by `make docker-up`.
- **User Communication**: Added a clear disclaimer about external asset loading (Wikimedia Commons) to manage user expectations regarding image visibility in certain geographic regions (e.g., Russia) where connectivity interruptions are common.

## Modified Files
- `README.md`

## Potential Technical Debt or Future Optimizations
- **Asset Localizing**: In the future, we might consider a feature to download external images to a local `public/uploads` directory during the seeding process (using `curl` or `file_get_contents` + `base64`) to ensure 100% offline/local visibility and bypass region-specific network blocks.
