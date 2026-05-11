function isNativeHls(video) {
    return video.canPlayType('application/vnd.apple.mpegurl') !== '';
}

/**
 * Attach HLS (.m3u8) to the hero background video so the browser loads small
 * segments instead of one large MP4. Safari uses native HLS; others load hls.js on demand.
 */
export async function initHeroHls() {
    const video = document.querySelector('video[data-ctc-hero-hls]');
    if (!video) return;

    const src = (video.dataset.ctcHeroHls || '').trim();
    if (!src) return;

    if (isNativeHls(video)) {
        video.src = src;
        return;
    }

    const { default: Hls } = await import('hls.js');

    if (!Hls.isSupported()) {
        video.src = src;
        return;
    }

    const hls = new Hls({
        enableWorker: true,
        lowLatencyMode: false,
        maxBufferLength: 24,
        maxMaxBufferLength: 48,
        startLevel: -1,
    });

    hls.loadSource(src);
    hls.attachMedia(video);

    hls.on(Hls.Events.ERROR, (_, data) => {
        if (!data.fatal) return;
        if (data.type === Hls.ErrorTypes.NETWORK_ERROR) {
            hls.startLoad();
            return;
        }
        if (data.type === Hls.ErrorTypes.MEDIA_ERROR) {
            hls.recoverMediaError();
        }
    });
}
