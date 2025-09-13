# Color Guidelines

This document outlines the color palette and usage guidelines for maintaining visual consistency across all design elements and interfaces.

## Color Palette

### Core Colors

#### Background & Surface
- **Background**: `#000000` (`--bg`)
  - Primary background for the entire application
  - Pure black for maximum contrast and modern dark theme aesthetic
  
- **Surface**: `#121212` (`--surface`)
  - Secondary background for cards, modals, and elevated elements
  - Provides subtle differentiation from main background
  - Use for content containers and panels

#### Text Colors
- **Text**: `#EAEAEA` (`--text`)
  - Primary text color for high readability on dark backgrounds
  - Use for headings, body text, and primary content
  
- **Muted**: `#A0A0A0` (`--muted`)
  - Secondary text color for less prominent information
  - Use for captions, labels, placeholder text, and metadata

### Accent Colors

#### Primary Accent (Blue)
- **Accent**: `#3B82F6` (`--accent`)
  - Primary brand color and main interactive element color
  - Use for primary buttons, links, and key UI elements
  
- **Accent Deep**: `#2563EB` (`--accent-deep`)
  - Darker variant for hover states and pressed buttons
  - Provides visual feedback for interactive elements
  
- **Accent Soft**: `#60A5FA` (`--accent-soft`)
  - Lighter variant for subtle accents and gradients
  - Use for highlights, selection states, and decorative elements

### Status Colors

#### Success
- **Success**: `#22C55E` (`--success`)
  - Indicates successful operations, confirmations, and positive states
  - Use for success messages, completed actions, and positive feedback

#### Warning
- **Warning**: `#EAB308` (`--warning`)
  - Indicates caution, pending states, or important information
  - Use for warning messages, form validation, and attention-grabbing elements

#### Error
- **Error**: `#EF4444` (`--error`)
  - Indicates errors, failures, and destructive actions
  - Use for error messages, validation failures, and delete confirmations

### Special Colors

#### Swiss Red
- **Swiss Red**: `#ea1d22` (`--swiss-red`)
  - Special accent color for specific branding or highlighting needs
  - Use sparingly for special occasions or brand-specific elements

## Visual Effects

### Focus Ring
- **Ring Effect**: `0 0 0 3px rgba(59, 130, 246, .35)` (`--ring`)
  - Provides accessible focus indication for interactive elements
  - Uses accent color with 35% opacity for subtle but visible feedback

### Shadows
- **Shadow**: `0 10px 30px rgba(0, 0, 0, .55)` (`--shadow`)
  - Creates depth and elevation for cards and floating elements
  - Strong shadow for dramatic elevation effect in dark theme

### Border Radius
- **Radius**: `16px` (`--radius`)
  - Standard border radius for consistent rounded corners
  - Apply to buttons, cards, input fields, and containers

## Usage Guidelines

### Hierarchy & Contrast
1. **Primary Content**: Use `--text` on `--bg` or `--surface` backgrounds
2. **Secondary Content**: Use `--muted` for less important information
3. **Interactive Elements**: Use `--accent` family colors for buttons, links, and controls
4. **Status Feedback**: Use appropriate status colors (`--success`, `--warning`, `--error`)

### Accessibility Considerations
- Maintain WCAG AA contrast ratios (4.5:1 for normal text, 3:1 for large text)
- Use focus ring (`--ring`) for all interactive elements
- Don't rely solely on color to convey information
- Test with colorblind users and accessibility tools

### Best Practices

#### Do:
- Use the CSS custom properties (variables) for consistency
- Apply hover and focus states using darker/lighter variants
- Maintain visual hierarchy through color contrast
- Use status colors appropriately for their intended purpose

#### Don't:
- Mix color values outside of the defined palette
- Use pure white or colors with insufficient contrast
- Overuse accent colors (reserve for important interactive elements)
- Apply multiple accent colors simultaneously without purpose

## Implementation

### CSS Custom Properties
```css
:root {
  --bg: #000000;
  --surface: #121212;
  --text: #EAEAEA;
  --muted: #A0A0A0;
  --accent: #3B82F6;
  --accent-deep: #2563EB;
  --accent-soft: #60A5FA;
  --success: #22C55E;
  --warning: #EAB308;
  --error: #EF4444;
  --swiss-red: #ea1d22;
  --ring: 0 0 0 3px rgba(59, 130, 246, .35);
  --radius: 16px;
  --shadow: 0 10px 30px rgba(0, 0, 0, .55);
}
```

### Usage Examples
```css
/* Primary button */
.btn-primary {
  background-color: var(--accent);
  color: white;
  border-radius: var(--radius);
}

.btn-primary:hover {
  background-color: var(--accent-deep);
}

.btn-primary:focus {
  box-shadow: var(--ring);
}

/* Card component */
.card {
  background-color: var(--surface);
  color: var(--text);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}

/* Status messages */
.success-message {
  background-color: var(--success);
  color: white;
}

.error-message {
  background-color: var(--error);
  color: white;
}
```

## Color Testing

### Tools for Validation
- WebAIM Contrast Checker
- Colour Contrast Analyser
- Browser DevTools accessibility features
- Colorblinding simulator tools

### Regular Audits
- Test color combinations for accessibility compliance
- Validate readability across different devices and lighting conditions
- Ensure consistent implementation across all components and pages

---
