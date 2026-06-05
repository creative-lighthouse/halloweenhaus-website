export function initYoutubeConsent() {
    document.querySelectorAll('.yt-consent').forEach(wrapper => {
        wrapper.addEventListener('click', () => activateYoutube(wrapper));
    });
}

function activateYoutube(wrapper) {
    const videoId = wrapper.dataset.videoid;
    const iframe = document.createElement('iframe');
    iframe.src = `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1`;
    iframe.title = 'YouTube video player';
    iframe.setAttribute('frameborder', '0');
    iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
    iframe.setAttribute('allowfullscreen', '');

    wrapper.innerHTML = '';
    wrapper.classList.add('yt-consent--active');
    wrapper.appendChild(iframe);
}
