<style>
	.s-hero {
	    position: relative;
	    color: #FFF;
	    background-color: #117bf3;
	    background-image: url({{ asset('images/pattern.svg') }}),linear-gradient(to right, #26afd1 0, #108AEC 100%);
	    background-position: right center,center center;
	    background-repeat: repeat-y;
	    font-size: 17px;
	    line-height: 1.53333333;
	    overflow: hidden;
	}
	.s-hero .-container {
	    margin: 0 auto;
	    padding: 32px 15px;
	    max-width: 1090px;
	    width: 100%;
	    position: relative;
	    min-height: 250px;
	    z-index: 2;
	}
	.g-row.ai-center, .g-column.ai-center, [class^="g-col"].ai-center {
	    align-items: center;
	}
	.g-row.jc-sp-between, .g-column.jc-sp-between, [class^="g-col"].jc-sp-between {
	    -webkit-justify-content: space-between;
	    justify-content: space-between;
	}
	.s-hero, .s-hero *, .s-hero *:before, .s-hero *:after {
	    box-sizing: border-box;
	}
	.g-row {
	    -webkit-flex: 1 auto;
	    flex: 1 auto;
	    -webkit-flex-flow: row nowrap;
	    flex-flow: row nowrap;
	}
	.g-row, .g-column {
	    position: relative;
	    display: -webkit-flex;
	    display: flex;
	}
	.s-hero [class^="g-col"] {
	    display: block;
	}
	.g-col6 {
	    -webkit-flex: none;
	    flex: none;
	}
	[class^="g-col"] {
	    display: inline-flex;
	    position: relative;
	}
	.s-hero .-title {
	    font-size: 27px;
	    line-height: 1.53333333;
	    margin-bottom: 12px;
	}
	.s-hero .-paragraph:last-child, .s-hero .-sub-paragraph:last-child {
	    margin-bottom: 0;
	}
	.g-col3 {
	    -webkit-flex: none;
	    flex: none;
	    flex-basis: 25%;
	    max-width: 25%;
	}
	.s-hero .-dismiss {
	    opacity: .65;
	    display: inline-block;
	    height: 18px;
	    vertical-align: middle;
	    position: absolute;
	    right: 16px;
	    border-radius: 2px;
	    top: 16px;
	    line-height: 1;
	    transition: opacity ease-in-out .25s;
	    cursor: pointer;
	}
	.s-hero .-dismiss {
	    color: #117bf3;
	    background-color: #FFF;
	}
	a {
	    color: #07C;
	    text-decoration: none;
	    cursor: pointer;
	}
	p {
	    clear: both;
	    margin-bottom: 1em;
	    margin-top: 0;
	}
	h1 {
	    font-size: 22px;
	}
	h1, h2, h3 {
	    line-height: 1.3;
	    margin: 0 0 1em;
	}
	.s-hero .svg-icon {
	    margin-bottom: 2px;
	}
	.s-hero, .s-hero *, .s-hero *:before, .s-hero *:after {
	    box-sizing: border-box;
	}
	.svg-icon {
	    vertical-align: bottom;
	}
	svg[Attributes Style] {
	    width: 18;
	    height: 18;
	}
	svg:not(:root), symbol, image, marker, pattern, foreignObject {
	    overflow: hidden;
	}
	a.fb-msg-btn{
		display: inline-block;
		font-family: inherit;
		font-size: 14px;
		font-weight: bold;
		color: #fff;
		text-align: center;
		padding: 12px 16px;
		margin: 0;
		background-color: #0084ff;
		border: 0;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		cursor: pointer;
		outline: none;
	}
	a:hover.fb-msg-btn {
		background-color: #0268c7;
	}
</style>
<div class="s-hero hero-container">
    <div class="-container g-row jc-sp-between ai-center">
        <div class="g-col6">
            <h1 class="-title">21st Century Tailoring</h1>
            <p class="-paragraph">You can now easily pick a style for your next outfit through your facebook messenger app with the help of our bot.</p>
            <p class="-paragraph g-col3"><a href="https://m.me/shakaradotng" class="fb-msg-btn" target="_blank">Message us on Facebook</a></p>
        </div>
    </div>
</div>
