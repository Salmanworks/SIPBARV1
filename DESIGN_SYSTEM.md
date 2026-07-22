# 🎨 SIPBAR Design System - Glassmorphism & Gradient Flow

## 📚 Table of Contents
1. [Overview](#overview)
2. [Color Palette](#color-palette)
3. [Glassmorphism Classes](#glassmorphism-classes)
4. [Components](#components)
5. [Animations](#animations)
6. [Usage Examples](#usage-examples)

---

## 🌟 Overview

SIPBAR menggunakan design system modern dengan tema **"Glassmorphism & Gradient Flow"** yang memberikan tampilan elegan, futuristik, dan user-friendly.

### Key Features:
- ✨ Glassmorphism effect dengan backdrop blur
- 🌈 Gradient meshes dan animated backgrounds
- 💫 Smooth animations dan micro-interactions
- 🎯 Accessible dan responsive
- 🚀 Optimized performance

---

## 🎨 Color Palette

### Primary Colors
```css
primary-900: #1e3a8a  (Navy Blue - Dark)
primary-500: #3b82f6  (Electric Blue)
primary-400: #60a5fa  (Light Blue)
```

### Gradient Presets
```html
<!-- Primary Gradient -->
<div class="bg-gradient-primary"></div>

<!-- Purple Gradient -->
<div class="bg-gradient-purple"></div>

<!-- Success Gradient -->
<div class="bg-gradient-success"></div>

<!-- Animated Gradient -->
<div class="bg-gradient-animated"></div>

<!-- Mesh Gradient -->
<div class="bg-gradient-mesh"></div>
```

---

## 💎 Glassmorphism Classes

### Base Glass Effects
```html
<!-- Light Glass (5% opacity) -->
<div class="glass-light">...</div>

<!-- Default Glass (10% opacity) -->
<div class="glass">...</div>

<!-- Medium Glass (15% opacity) -->
<div class="glass-medium">...</div>

<!-- Heavy Glass (20% opacity) -->
<div class="glass-heavy">...</div>

<!-- Dark Glass -->
<div class="glass-dark">...</div>
```

### Glass Card
```html
<!-- Basic Glass Card -->
<div class="glass-card">
  <h3>Card Title</h3>
  <p>Card content...</p>
</div>

<!-- Glass Card with Hover Effect -->
<div class="glass-card hover-scale">
  Content...
</div>

<!-- Glass Card with Shine Effect -->
<div class="glass-card card-shine">
  Content...
</div>
```

---

## 🧩 Components

### 1. Stat Card Component
```blade
<x-stat-card 
    title="Total Barang" 
    value="150" 
    icon="📦"
    gradient="blue"
    trend="up"
    trendValue="+12%"
    description="dari bulan lalu"
/>
```

**Available Gradients:** blue, purple, emerald, rose, amber

### 2. Status Badge Component
```blade
<!-- Success Badge -->
<x-badge-status status="success">Tersedia</x-badge-status>

<!-- Warning Badge with Pulse -->
<x-badge-status status="warning" pulse>Pending</x-badge-status>

<!-- Danger Badge with Custom Icon -->
<x-badge-status status="danger" icon="🔴">Terlambat</x-badge-status>
```

**Available Status:** success, warning, danger, info, purple

### 3. Empty State Component
```blade
<x-empty-state
    icon="📦"
    title="Belum Ada Peminjaman"
    description="Anda belum memiliki riwayat peminjaman. Mulai ajukan peminjaman sekarang!"
    actionText="Ajukan Peminjaman"
    actionUrl="{{ route('peminjaman.create') }}"
/>
```

### 4. Glass Card Component
```blade
<!-- White Glass Card -->
<x-glass-card variant="white" hover shine class="p-6">
    <h3>Card Content</h3>
</x-glass-card>

<!-- Light Glass Card -->
<x-glass-card variant="light" class="p-4">
    Content...
</x-glass-card>
```

**Variants:** default, light, medium, heavy, white

### 5. Loading Skeleton
```blade
<!-- Card Skeleton (3 cards) -->
<x-loading-skeleton type="card" count="3" />

<!-- List Skeleton (5 items) -->
<x-loading-skeleton type="list" count="5" />

<!-- Table Skeleton (10 rows) -->
<x-loading-skeleton type="table" count="10" />
```

---

## ✨ Animations

### Built-in Animations
```html
<!-- Gradient Animation -->
<div class="bg-gradient-animated"></div>

<!-- Float Animation -->
<div class="float">🎈</div>

<!-- Pulse Soft -->
<span class="pulse-dot bg-emerald-400"></span>

<!-- Shimmer Effect -->
<div class="shimmer">Content</div>

<!-- Slide Up -->
<div class="animate-slide-up">Content</div>

<!-- Scale In -->
<div class="animate-scale-in">Content</div>

<!-- Glow Effect -->
<div class="animate-glow">Content</div>
```

### Hover Effects
```html
<!-- Card Lift -->
<div class="card-lift">
  Lifts on hover
</div>

<!-- Hover Scale -->
<div class="hover-scale">
  Scales on hover
</div>

<!-- Card Shine -->
<div class="card-shine">
  Shine effect on hover
</div>
```

---

## 🎯 Usage Examples

### Example 1: Dashboard Stat Cards
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <x-stat-card 
        title="Total Barang" 
        value="150" 
        icon="📦"
        gradient="blue"
        trend="up"
        trendValue="+12%"
        description="bulan ini"
    />
    
    <x-stat-card 
        title="Dipinjam" 
        value="23" 
        icon="🔄"
        gradient="purple"
        trend="down"
        trendValue="-5%"
    />
    
    <x-stat-card 
        title="Terlambat" 
        value="5" 
        icon="⚠️"
        gradient="rose"
    />
    
    <x-stat-card 
        title="Pengguna Aktif" 
        value="50" 
        icon="👥"
        gradient="emerald"
        trend="up"
        trendValue="+8%"
    />
</div>
```

### Example 2: Status Tracking
```blade
<div class="space-y-4">
    @foreach($peminjaman as $item)
    <div class="glass-card">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold">{{ $item->barang->nama }}</h3>
                <p class="text-sm text-slate-600">{{ $item->user->name }}</p>
            </div>
            
            @if($item->status === 'disetujui')
                <x-badge-status status="success" pulse>Disetujui</x-badge-status>
            @elseif($item->status === 'pending')
                <x-badge-status status="warning">Pending</x-badge-status>
            @elseif($item->status === 'terlambat')
                <x-badge-status status="danger" pulse>Terlambat</x-badge-status>
            @else
                <x-badge-status status="info">{{ $item->status }}</x-badge-status>
            @endif
        </div>
    </div>
    @endforeach
</div>
```

### Example 3: Hero Section with Glass
```blade
<section class="relative min-h-screen bg-gradient-mesh">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-64 h-64 bg-blue-500/30 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-purple-500/30 rounded-full blur-3xl"></div>
    </div>
    
    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 py-20">
        <div class="glass-card max-w-2xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-white mb-6 text-shadow-lg">
                Welcome to <span class="text-gradient">SIPBAR</span>
            </h1>
            <p class="text-white/90 mb-8">
                Modern inventory management system
            </p>
            <button class="btn-glow">
                Get Started
            </button>
        </div>
    </div>
</section>
```

### Example 4: Button Variants
```blade
<!-- Glow Button -->
<button class="btn-glow">
    Primary Action
</button>

<!-- Glass Button -->
<button class="glass-medium rounded-xl px-6 py-3 text-white hover:glass-heavy transition-all">
    Secondary Action
</button>

<!-- Gradient Text Button -->
<button class="text-gradient font-semibold">
    Link Button
</button>
```

### Example 5: Card Grid with Masonry
```blade
<div class="grid-masonry">
    @foreach($barang as $item)
    <div class="glass-card card-lift">
        <img src="{{ $item->foto }}" alt="{{ $item->nama }}" class="rounded-xl mb-4">
        <h3 class="font-semibold mb-2">{{ $item->nama }}</h3>
        <div class="flex items-center justify-between">
            <x-badge-status status="success">
                Stok: {{ $item->stok }}
            </x-badge-status>
            <span class="text-sm text-slate-600">{{ $item->kategori->nama }}</span>
        </div>
    </div>
    @endforeach
</div>
```

---

## 🎭 Shadow Utilities

```html
<!-- Glass Shadow -->
<div class="shadow-glass"></div>
<div class="shadow-glass-lg"></div>

<!-- Glow Shadow -->
<div class="shadow-glow-sm"></div>
<div class="shadow-glow"></div>
<div class="shadow-glow-lg"></div>
```

---

## 📐 Layout Utilities

### Grid Pattern Background
```html
<div class="grid-pattern">
    Content with grid background
</div>
```

### Border Gradient
```html
<div class="border-gradient p-6 rounded-xl">
    Content with gradient border
</div>
```

### Text Effects
```html
<!-- Gradient Text -->
<h1 class="text-gradient">Gradient Text</h1>
<h1 class="text-gradient-primary">Primary Gradient</h1>

<!-- Text Shadow -->
<h1 class="text-shadow-sm">Small Shadow</h1>
<h1 class="text-shadow">Medium Shadow</h1>
<h1 class="text-shadow-lg">Large Shadow</h1>
```

---

## 🚀 Performance Tips

1. **Use backdrop-blur wisely** - Can be performance intensive
2. **Limit nested glass effects** - Keep it simple
3. **Optimize images** - Use WebP format
4. **Lazy load animations** - Use Intersection Observer
5. **Test on mobile devices** - Ensure smooth scrolling

---

## 📱 Responsive Design

All components are mobile-first and responsive:

```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Responsive grid -->
</div>

<div class="text-2xl sm:text-3xl lg:text-5xl">
    <!-- Responsive text -->
</div>
```

---

## 🎨 Customization

### Extending Colors
```javascript
// tailwind.config.js
theme: {
  extend: {
    colors: {
      brand: {
        500: '#your-color',
      }
    }
  }
}
```

### Custom Animations
```css
/* app.css */
@layer components {
  .my-animation {
    animation: myAnim 1s ease-in-out;
  }
  
  @keyframes myAnim {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
  }
}
```

---

## 🐛 Troubleshooting

### Issue: Glass effect not showing
**Solution:** Make sure backdrop-filter is supported in browser

### Issue: Animations laggy
**Solution:** Reduce blur intensity or use will-change CSS property

### Issue: Gradient not animating
**Solution:** Check if background-size is set to 200% or more

---

## 📚 Resources

- [Tailwind CSS Docs](https://tailwindcss.com)
- [CSS Glassmorphism Generator](https://hype4.academy/tools/glassmorphism-generator)
- [Gradient Generator](https://cssgradient.io/)

---

**Built with ❤️ for SIPBAR**
