@props([
    'class' => '',
])

{{-- Country outlines from Natural Earth 110m (see scripts/generate-africa-country-paths.cjs). Bomet ~35.12°E, -0.78°S --}}
<svg
    class="{{ $class }}"
    viewBox="0 0 520 580"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    preserveAspectRatio="xMaxYMid meet"
    aria-hidden="true"
>
    <defs>
        <marker id="ctc-arr-gold" markerWidth="5" markerHeight="5" refX="4.2" refY="2.5" orient="auto">
            <path d="M0 0 L0 5 L5 2.5 Z" fill="#e4c373" fill-opacity="0.45" />
        </marker>
        <marker id="ctc-arr-teal" markerWidth="5" markerHeight="5" refX="4.2" refY="2.5" orient="auto">
            <path d="M0 0 L0 5 L5 2.5 Z" fill="#62a3a1" fill-opacity="0.45" />
        </marker>
        <marker id="ctc-arr-blue" markerWidth="5" markerHeight="5" refX="4.2" refY="2.5" orient="auto">
            <path d="M0 0 L0 5 L5 2.5 Z" fill="#1a1a68" fill-opacity="0.4" />
        </marker>
        <marker id="ctc-arr-magenta" markerWidth="5" markerHeight="5" refX="4.2" refY="2.5" orient="auto">
            <path d="M0 0 L0 5 L5 2.5 Z" fill="#b83280" fill-opacity="0.4" />
        </marker>
        <radialGradient id="ctc-bomet-glow" cx="50%" cy="50%" r="50%">
            <stop offset="0%" stop-color="#62a3a1" stop-opacity="0.28" />
            <stop offset="70%" stop-color="#1a1a68" stop-opacity="0.08" />
            <stop offset="100%" stop-color="#1a1a68" stop-opacity="0" />
        </radialGradient>
    </defs>

    <g class="ctc-impact-africa-countries" fill="none">
        @include('components.partials.africa-country-paths')
    </g>

    <circle cx="363.4" cy="305" r="38" fill="url(#ctc-bomet-glow)" />
    <circle cx="363.4" cy="305" r="6.5" fill="#1a1a68" fill-opacity="0.75" stroke="#e4c373" stroke-opacity="0.65" stroke-width="1.5" />
    <circle cx="363.4" cy="305" r="2.2" fill="#62a3a1" fill-opacity="0.85" />

    <g class="ctc-impact-rays" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path class="ctc-impact-ray" d="M363.4 305 C310 218 175 100 68 42" stroke="#e4c373" stroke-opacity="0.4" stroke-width="1.35" marker-end="url(#ctc-arr-gold)" />
        <path class="ctc-impact-ray" d="M363.4 305 C338 158 268 58 198 28" stroke="#62a3a1" stroke-opacity="0.38" stroke-width="1.35" marker-end="url(#ctc-arr-teal)" />
        <path class="ctc-impact-ray" d="M363.4 305 C402 112 458 62 508 78" stroke="#1a1a68" stroke-opacity="0.35" stroke-width="1.35" marker-end="url(#ctc-arr-blue)" />
        <path class="ctc-impact-ray" d="M363.4 305 C428 118 492 138 515 208" stroke="#b83280" stroke-opacity="0.36" stroke-width="1.35" marker-end="url(#ctc-arr-magenta)" />
        <path class="ctc-impact-ray" d="M363.4 305 C438 228 478 288 492 358" stroke="#e4c373" stroke-opacity="0.34" stroke-width="1.15" marker-end="url(#ctc-arr-gold)" />
        <path class="ctc-impact-ray" d="M363.4 305 C318 338 272 422 252 508" stroke="#62a3a1" stroke-opacity="0.34" stroke-width="1.15" marker-end="url(#ctc-arr-teal)" />
        <path class="ctc-impact-ray" d="M363.4 305 C268 288 148 268 28 258" stroke="#1a1a68" stroke-opacity="0.32" stroke-width="1.15" marker-end="url(#ctc-arr-blue)" />
        <path class="ctc-impact-ray" d="M363.4 305 C298 378 205 442 105 485" stroke="#b83280" stroke-opacity="0.34" stroke-width="1.15" marker-end="url(#ctc-arr-magenta)" />
    </g>
</svg>
