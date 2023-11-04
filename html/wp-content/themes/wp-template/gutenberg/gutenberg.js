/**
 * Add rich text
 * https://celtislab.net/archives/20200319/wordpress-richtext-toolbar-button/
 * https://ja.wordpress.org/team/handbook/block-editor/how-to-guides/format-api/
 */
(function () {
    const { Fragment, createElement } = wp.element;
    const { registerFormatType, toggleFormat } = wp.richText;
    const { RichTextToolbarButton, RichTextShortcut, BlockFormatControls } = wp.blockEditor;
    const el = createElement;
    const tagTypes = [];
    tagTypes.push({ tag: 'mark', class: 'wp-marker', title: 'マーカー',icon: 'edit' });
    tagTypes.push({ tag: 'span', class: 'wp-color-primary', title: 'カラー', icon: 'edit' });
    tagTypes.push({ tag: 'span', class: 'wp-font-large', title: '大文字',icon: 'edit' });
    tagTypes.push({ tag: 'span', class: 'wp-font-small', title: '小文字',icon: 'edit' });
    tagTypes.map((idx) => {
        let type = 'custom/richtext-' + idx.tag;
        if(idx.class !== null){
            type += '-' + idx.class;
        }
        registerFormatType( type, {
            title: idx.title,
            tagName: idx.tag,
            className: idx.class,
            edit({ isActive, value, onChange }) {
                return (
                    el( Fragment,
                        {},
                        el( RichTextToolbarButton,
                            { icon: idx.icon,
								title: idx.title,
								isActive: isActive,
								onClick: () => onChange( toggleFormat(value, { type: type })),
                            }
                        )
                    )
                );
            },
        });
    })
}());

/**
 * Remove rich text type
 * https://celtislab.net/archives/20200319/wordpress-richtext-toolbar-button/
 */
wp.domReady(function() {
	wp.richText.unregisterFormatType('core/italic');
	wp.richText.unregisterFormatType('core/code');
	wp.richText.unregisterFormatType('core/image');
	wp.richText.unregisterFormatType('core/keyboard');
	wp.richText.unregisterFormatType('core/superscript');
	wp.richText.unregisterFormatType('core/subscript');
	wp.richText.unregisterFormatType('core/underline');
	wp.richText.unregisterFormatType('core/text-color');
	wp.richText.unregisterFormatType('core/strikethrough');
	wp.richText.unregisterFormatType('core/language');
	wp.richText.unregisterFormatType('core/footnote');
	// wp.richText.unregisterFormatType('core/bold');
	// wp.richText.unregisterFormatType('core/link');
});