<div id="related-portfolio-pro">
    <h2>Related Styles</h2>
    @forelse($related as $item)
    <div class="related-columns-pro">
        <article>
            <a class="gallery-container-pro" href="{{ route('item', $item->id) }}">
                <div class="zoom-image-container-pro">
                    <img alt="{{ $item->getName() }}" class="attachment-progression-gallery-related wp-post-image" height="450 !important" src="{{ $item->getImage() }}" width="600">
                </div>
                <div class="gallery-index-text">
                    <ul>
                        {{ $item->getCategoriesLabel() }}
                    </ul>
                    <div class="gallery-title-index">
                        {{ $item->getName() }}
                    </div>
                </div>
            </a>
        </article>
    </div>
    @empty
        <h4>None</h4>
    @endforelse
    <div class="clearfix"></div>
</div><!-- #related-portfolio-pro -->
