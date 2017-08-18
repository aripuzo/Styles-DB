<style>
	.s-hero {
	    position: relative;
	    color: #FFF;
	    background-color: #117bf3;
	    background-image: url(../../img/hero/pattern.svg?v=4b5c30ad0473),linear-gradient(to right, #126CFA 0, #108AEC 100%);
	    background-position: right center,center center;
	    background-repeat: no-repeat,no-repeat;
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
	    flex-basis: 50%;
	    max-width: 50%;
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
</style>
<div class="s-hero hero-container">
    <div class="-container g-row jc-sp-between ai-center">
        <div class="g-col6">
            <h1 class="-title">Learn, Share, Build</h1>
            <p class="-paragraph">Each month, over 50 million developers come to Stack Overflow to learn, share their knowledge, and build their careers.</p>
            <p class="-paragraph">Join the world’s largest developer community.</p>
            <p class="-paragraph g-col3"><a href="/users/signup?ssrc=hero&amp;returnurl=%2fusers%2fstory%2fcurrent&amp;amp;utm_source=stackoverflow.com&amp;amp;utm_medium=dev-story&amp;amp;utm_campaign=signup-redirect" class="btn-outlined -white _medium _block">Sign Up</a></p>
        </div>

        <a id="close" href="#" class="js-dismiss -dismiss" title="dismiss">
        	<svg role="icon" class="svg-icon iconClear" width="18" height="18" viewBox="0 0 18 18"><path d="M15 4.41L13.59 3 9 7.59 4.41 3 3 4.41 7.59 9 3 13.59 4.41 15 9 10.41 13.59 15 15 13.59 10.41 9z"></path></svg>
        </a>
    </div>
</div>
