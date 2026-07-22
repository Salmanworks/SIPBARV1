# 🎨 SIPBAR Icon System - Heroicons Guide

## 📚 Overview

SIPBAR menggunakan **Heroicons** - sistem icon SVG profesional yang beautiful, handcrafted, dan open-source. Semua icon sudah terintegrasi dan siap pakai!

---

## ✨ Cara Penggunaan

### Basic Usage
```blade
<x-icon name="cube" size="md" />
```

### Available Parameters

| Parameter | Type | Default | Options | Description |
|-----------|------|---------|---------|-------------|
| `name` | string | 'cube' | (lihat daftar di bawah) | Nama icon |
| `variant` | string | 'outline' | outline, solid | Style icon |
| `size` | string | 'md' | xs, sm, md, lg, xl, 2xl, 3xl | Ukuran icon |
| `class` | string | - | any | Custom CSS classes |

---

## 📦 Available Icons

### 🏢 Business & Data Icons

#### cube
```blade
<x-icon name="cube" size="md" />
```
**Use for:** Barang, Inventory, Items

#### chart-bar
```blade
<x-icon name="chart-bar" size="md" />
```
**Use for:** Statistics, Dashboard, Analytics

#### document-text
```blade
<x-icon name="document-text" size="md" />
```
**Use for:** Documents, Reports, Forms

---

### 👥 User & People Icons

#### users
```blade
<x-icon name="users" size="md" />
```
**Use for:** Users, Team, Group

#### academic-cap
```blade
<x-icon name="academic-cap" size="md" />
```
**Use for:** School, Education, Students

---

### ⏰ Time & Status Icons

#### clock
```blade
<x-icon name="clock" size="md" />
```
**Use for:** Time, Schedule, Duration

#### calendar
```blade
<x-icon name="calendar" size="md" />
```
**Use for:** Date, Event, Booking

#### bell
```blade
<x-icon name="bell" size="md" />
```
**Use for:** Notifications, Alerts, Reminders

---

### ✅ Action & Status Icons

#### check-circle
```blade
<x-icon name="check-circle" size="md" />
<!-- Solid variant -->
<x-icon name="check-circle" size="md" variant="solid" />
```
**Use for:** Success, Approved, Completed

#### x-circle
```blade
<x-icon name="x-circle" size="md" />
<!-- Solid variant -->
<x-icon name="x-circle" size="md" variant="solid" />
```
**Use for:** Error, Rejected, Failed

#### exclamation-triangle
```blade
<x-icon name="exclamation-triangle" size="md" />
```
**Use for:** Warning, Alert, Caution

#### shield-check
```blade
<x-icon name="shield-check" size="md" />
```
**Use for:** Security, Protected, Verified

---

### ➡️ Navigation Icons

#### arrow-right
```blade
<x-icon name="arrow-right" size="md" />
```
**Use for:** Next, Forward, Continue

#### arrow-up
```blade
<x-icon name="arrow-up" size="md" />
```
**Use for:** Upload, Increase, Scroll Up

#### arrow-trending-up
```blade
<x-icon name="arrow-trending-up" size="md" />
```
**Use for:** Growth, Increase, Positive Trend

#### arrow-trending-down
```blade
<x-icon name="arrow-trending-down" size="md" />
```
**Use for:** Decrease, Negative Trend, Loss

---

### 🔄 Process Icons

#### refresh
```blade
<x-icon name="refresh" size="md" />
```
**Use for:** Reload, Sync, Update

#### sparkles
```blade
<x-icon name="sparkles" size="md" />
```
**Use for:** New, Featured, Special

#### fire
```blade
<x-icon name="fire" size="md" />
```
**Use for:** Trending, Hot, Popular

---

### 📞 Contact Icons

#### envelope
```blade
<x-icon name="envelope" size="md" />
```
**Use for:** Email, Message, Contact

#### phone
```blade
<x-icon name="phone" size="md" />
```
**Use for:** Phone, Call, Contact

#### map-pin
```blade
<x-icon name="map-pin" size="md" />
```
**Use for:** Location, Address, Place

---

### 🛠️ Action Icons

#### plus
```blade
<x-icon name="plus" size="md" />
```
**Use for:** Add, Create, New

#### magnifying-glass
```blade
<x-icon name="magnifying-glass" size="md" />
```
**Use for:** Search, Find, Look

#### camera
```blade
<x-icon name="camera" size="md" />
```
**Use for:** Photo, Image, Upload

#### cog
```blade
<x-icon name="cog" size="md" />
```
**Use for:** Settings, Configuration, Options

---

### ⭐ Special Icons

#### star
```blade
<x-icon name="star" size="md" />
<!-- Solid variant -->
<x-icon name="star" size="md" variant="solid" />
```
**Use for:** Favorite, Rating, Featured

#### heart
```blade
<x-icon name="heart" size="md" />
```
**Use for:** Like, Favorite, Love

#### tag
```blade
<x-icon name="tag" size="md" />
```
**Use for:** Label, Category, Tag

---

## 📐 Size Reference

| Size | Class | Pixels | Use Case |
|------|-------|--------|----------|
| xs | w-3 h-3 | 12px | Inline text, badges |
| sm | w-4 h-4 | 16px | Small buttons, compact UI |
| md | w-5 h-5 | 20px | **Default** - buttons, lists |
| lg | w-6 h-6 | 24px | Headers, prominent actions |
| xl | w-8 h-8 | 32px | Large buttons, cards |
| 2xl | w-10 h-10 | 40px | Hero sections, emphasis |
| 3xl | w-12 h-12 | 48px | Large decorative elements |

---

## 💡 Real-World Examples

### Example 1: Button with Icon
```blade
<button class="btn-glow group">
    <x-icon name="plus" size="md" />
    <span>Tambah Barang</span>
    <x-icon name="arrow-right" size="sm" class="transition-transform group-hover:translate-x-1" />
</button>
```

### Example 2: Status Badge
```blade
<x-badge-status status="success">
    {{-- Icon automatically included --}}
    Tersedia
</x-badge-status>

{{-- Or with custom icon --}}
<x-badge-status status="info" icon="sparkles">
    Premium
</x-badge-status>
```

### Example 3: Stat Card
```blade
<x-stat-card 
    title="Total Barang" 
    value="150" 
    icon="cube"
    gradient="blue"
    trend="up"
    trendValue="+12%"
/>
```

### Example 4: Empty State
```blade
<x-empty-state
    icon="cube"
    title="Belum Ada Barang"
    description="Mulai tambahkan barang ke inventaris Anda."
    actionText="Tambah Barang"
    actionUrl="{{ route('barang.create') }}"
/>
```

### Example 5: Navigation Link
```blade
<a href="#" class="flex items-center gap-3 text-slate-700 hover:text-blue-600 transition-colors">
    <x-icon name="chart-bar" size="md" />
    <span>Dashboard</span>
</a>
```

### Example 6: Info Card
```blade
<div class="glass-card">
    <div class="flex items-center gap-4 mb-4">
        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
            <x-icon name="bell" size="lg" class="text-white" />
        </div>
        <div>
            <h3 class="font-bold">Notifikasi</h3>
            <p class="text-sm text-slate-600">3 notifikasi baru</p>
        </div>
    </div>
</div>
```

### Example 7: List with Icons
```blade
<ul class="space-y-3">
    <li class="flex items-center gap-3">
        <x-icon name="check-circle" size="md" class="text-emerald-500" variant="solid" />
        <span>Real-time tracking</span>
    </li>
    <li class="flex items-center gap-3">
        <x-icon name="check-circle" size="md" class="text-emerald-500" variant="solid" />
        <span>Automated reports</span>
    </li>
    <li class="flex items-center gap-3">
        <x-icon name="check-circle" size="md" class="text-emerald-500" variant="solid" />
        <span>Secure encryption</span>
    </li>
</ul>
```

---

## 🎨 Styling Tips

### Color Classes
```blade
<!-- Success -->
<x-icon name="check-circle" class="text-emerald-500" />

<!-- Warning -->
<x-icon name="exclamation-triangle" class="text-amber-500" />

<!-- Error -->
<x-icon name="x-circle" class="text-rose-500" />

<!-- Info -->
<x-icon name="sparkles" class="text-blue-500" />

<!-- Gradient Text -->
<x-icon name="star" class="text-gradient" />
```

### With Animations
```blade
<!-- Spin -->
<x-icon name="refresh" class="animate-spin" />

<!-- Pulse -->
<x-icon name="bell" class="animate-pulse" />

<!-- Float -->
<x-icon name="sparkles" class="float" />

<!-- Bounce -->
<x-icon name="arrow-up" class="animate-bounce" />
```

### Hover Effects
```blade
<div class="group">
    <x-icon name="arrow-right" class="transition-transform group-hover:translate-x-2" />
</div>

<div class="group">
    <x-icon name="heart" class="transition-all group-hover:scale-125 group-hover:text-rose-500" />
</div>
```

---

## 🔧 Advanced Usage

### Conditional Icons
```blade
@if($item->status === 'available')
    <x-icon name="check-circle" class="text-emerald-500" variant="solid" />
@elseif($item->status === 'borrowed')
    <x-icon name="clock" class="text-blue-500" />
@else
    <x-icon name="x-circle" class="text-rose-500" />
@endif
```

### Loop with Icons
```blade
@foreach([
    ['icon' => 'shield-check', 'text' => 'Secure'],
    ['icon' => 'clock', 'text' => '24/7 Support'],
    ['icon' => 'star', 'text' => 'Top Rated'],
] as $feature)
    <div class="flex items-center gap-2">
        <x-icon :name="$feature['icon']" size="sm" />
        <span>{{ $feature['text'] }}</span>
    </div>
@endforeach
```

### Component Props
```blade
@props(['icon' => 'cube', 'title' => '', 'value' => ''])

<div class="glass-card">
    <x-icon :name="$icon" size="xl" />
    <h3>{{ $title }}</h3>
    <p>{{ $value }}</p>
</div>
```

---

## 📱 Responsive Sizing

```blade
<!-- Responsive icon size -->
<x-icon name="cube" class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" />

<!-- Or use size prop with responsive classes -->
<x-icon name="cube" size="md" class="sm:!w-6 sm:!h-6 lg:!w-8 lg:!h-8" />
```

---

## 🚀 Performance Tips

1. **Use outline by default** - Lighter DOM, better performance
2. **Use solid for small icons** - Better visibility at small sizes
3. **Avoid too many large icons** - Can impact load time
4. **Use CSS for colors** - More flexible than inline styles

---

## 🎯 Icon Selection Guide

| Use Case | Recommended Icon | Alternative |
|----------|------------------|-------------|
| Inventory Items | cube | tag |
| Add New | plus | sparkles |
| Search | magnifying-glass | - |
| Success | check-circle | shield-check |
| Error | x-circle | exclamation-triangle |
| Loading | refresh (animated) | clock |
| Statistics | chart-bar | document-text |
| Users | users | academic-cap |
| Settings | cog | - |
| Notifications | bell | envelope |
| Time/Date | clock | calendar |
| Location | map-pin | - |
| Trending | fire | arrow-trending-up |

---

## 🐛 Troubleshooting

### Icon tidak muncul
**Problem:** Icon component tidak di-render
**Solution:** 
```bash
# Clear view cache
php artisan view:clear

# Rebuild assets
npm run build
```

### Icon terlalu kecil/besar
**Problem:** Size tidak sesuai
**Solution:** Gunakan size prop atau custom class
```blade
<x-icon name="cube" size="xl" />
<!-- or -->
<x-icon name="cube" class="w-10 h-10" />
```

### Icon warna tidak berubah
**Problem:** Color class tidak apply
**Solution:** Pastikan menggunakan `class` attribute
```blade
<x-icon name="star" class="text-yellow-500" />
```

---

## 📚 Resources

- [Heroicons Official](https://heroicons.com/) - Browse all available icons
- [Tailwind CSS Colors](https://tailwindcss.com/docs/customizing-colors) - Color options
- [SIPBAR Design System](./DESIGN_SYSTEM.md) - Complete design guide

---

**Happy Designing! 🎨**

Built with ❤️ for SIPBAR
