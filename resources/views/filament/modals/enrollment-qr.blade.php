<div style="padding: 24px;">
    <p style="font-size: 14px; color: #9ca3af; margin-bottom: 20px;">
        {{ __('fields.enrollment_url_description') }}
    </p>

    {{-- URL Display --}}
    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 28px;">
        <input
            type="text"
            value="{{ $url }}"
            readonly
            id="enrollment-url-{{ $slug }}"
            style="flex: 1; padding: 10px 14px; font-size: 13px; border: 1px solid #374151; border-radius: 8px; background: #1f2937; color: #e5e7eb; outline: none;"
        />
        <button
            type="button"
            x-data="{ copied: false }"
            x-on:click="
                const input = document.getElementById('enrollment-url-{{ $slug }}');
                input.select();
                document.execCommand('copy');
                window.getSelection().removeAllRanges();
                copied = true;
                setTimeout(() => copied = false, 2000);
            "
            style="padding: 10px; border: 1px solid #374151; border-radius: 8px; background: #1f2937; cursor: pointer; transition: background 0.2s;"
            title="{{ __('fields.copy_url') }}"
        >
            <svg x-show="!copied" style="width: 18px; height: 18px; color: #9ca3af;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
            </svg>
            <svg x-show="copied" x-cloak style="width: 18px; height: 18px; color: #22c55e;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </button>
    </div>

    {{-- QR Code --}}
    <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(600)->margin(1)->generate($url) !!}
        </div>
        <a
            href="{{ route('qr.enrollment', $slug) }}"
            download="qr-registro-{{ $slug }}.png"
            style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #f59e0b; color: #000; font-size: 13px; font-weight: 600; border-radius: 8px; text-decoration: none; transition: background 0.2s;"
        >
            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            {{ __('fields.download_qr') }}
        </a>
    </div>
</div>
