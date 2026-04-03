# Log: Multi-Level Sorting Redesign (Phase 11)

## Technical Decisions (ADR style)

### 1. Static Sort Grid
**Decision**: Replace the "Add Layer" dropdown with a static grid of three persistent buttons.
**Rationale**: Persistent fields provide better visibility and accessibility, as requested. The grid layout ensures consistent spacing and a focused user experience.

### 2. Multi-Level Priority Logic in Smarty
**Decision**: Implement the priority (1, 2, 3) and URL building logic directly in the Smarty template.
**Rationale**: While some logic belongs in the Action, the specific UI state mapping (is active? what index? what happens on click?) is presentation-intensive. Moving this to Smarty provides high performance and immediate update capability via AJAX without complex backend recalculations.

### 3. Priority Badges and Direction Toggles
**Decision**: Use numbered badges (1, 2, 3) and direction arrows (&darr;/&uarr;) to indicate sorting weight and direction.
**Rationale**: This fulfilling the requirement for explicit UI indication, ensuring users understand the current sorting sequence at a glance.

### 4. Grouped Styles within Template
**Decision**: Keep Phase 11 specific styles within a `<style>` block in `category_page.tpl` for now.
**Rationale**: This isolates the redesign styles during this phase of development, making it easier to iterate and test without affecting global SCSS until finalized.

## Modified Files
- `templates/category_page.tpl` [MODIFY]
- `.obsidian_vault/Current_Task.md` [MODIFY]

## Potential Technical Debt or Future Optimizations
- **URL Limit**: For very large numbers of sortable columns, the current comma-separated URL string could become long. However, for three static fields, it's perfectly safe.
- **Smarty Logic Complexity**: The Smarty logic for building the `newSort` and `remSort` URLs is becoming slightly complex. In the future, this could be refactored into a custom Smarty plugin or a dedicated View Model.
- **Mobile Responsive Layout**: For very small screens, the horizontal sort bar might need to wrap vertically. The current CSS uses `flex-wrap: wrap` to handle this.
