# DESIGN.md — TaskFlow (Productivity Workspace)

> Design specification derived from **Better-Design** (anti-AI-slop rules), **UI/UX Pro Max** (Productivity Design System), and **Inspo** real-world references (Todoist/Linear patterns).

---

## 1. Identity & Art Direction
- **Concept**: Focused Personal Productivity Workspace for Students (UKK Edition).
- **Inspiration**: Linear & Todoist ergonomics. Fast, direct, zero marketing fluff inside the tool.
- **Tone**: Clean, dependable, high-contrast, distraction-free.

---

## 2. Anti-AI-Slop Directives (Strictly Followed)
- **No `marketing-in-tool`**: Removed the oversized hero banner that pushed user data off-screen. Opens directly on the work.
- **No `ai-palette`**: Replaced generic purple-indigo gradients with a calibrated productivity palette (Teal `#0D9488`, Deep Slate `#0F172A`, Crisp White `#FFFFFF`).
- **No `icon-tile`**: Removed redundant large icon boxes inside cards.
- **No `gradient-text`**: All headings and metrics use solid, high-contrast colors.
- **No `tracked-caps-label`**: Clean, legible sentence-case typography.
- **No `cardocalypse`**: Unified workspace card with clean dividers rather than deeply nested bloated cards.

---

## 3. Design Tokens

### Color Palette
- `--bg-canvas`: `#f8fafc` (Light canvas)
- `--surface`: `#ffffff` (Pure white containers)
- `--border-hairline`: `#e2e8f0` (Standard hairline border)
- `--border-strong`: `#cbd5e1` (Hover/focus border)
- `--text-main`: `#0f172a` (Deep slate heading/title)
- `--text-sub`: `#475569` (Secondary details, contrast > 6:1)
- `--text-muted`: `#64748b` (Meta timestamps)
- `--primary`: `#0d9488` (Teal focus)
- `--primary-hover`: `#0f766e`
- `--priority-high`: `#dc2626` (Crimson)
- `--priority-med`: `#d97706` (Amber)
- `--priority-low`: `#059669` (Emerald)

### Typography
- Font Family: `'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif`
- Scale:
  - Workspace Title: `1.5rem` (`24px`), `font-weight: 800`
  - Section/Task Title: `0.95rem` (`15px`), `font-weight: 600`
  - Body / Form Inputs: `0.9rem` (`14px`), `font-weight: 500`
  - Badges / Meta: `0.78rem` (`12.5px`), `font-weight: 600`

---

## 4. Interaction Patterns
- **Immediate Task Access**: Active filter tabs ("Semua", "Belum Selesai", "Sedang Dikerjakan", "Selesai") with active count chips.
- **One-Click Checkbox Completion**: Form toggle circle on each task for instant completion.
- **Fast Search & Category Filtering**: Inline compact filter bar.
- **Accessible Touch & Focus Targets**: Minimum 44×44px hit areas for buttons and inputs.

