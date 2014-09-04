$(document).ready(function () {
    size_li = $("#artistGrid li").size();
    var jump = 12;
	x=12;
    $('#artistGrid li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+jump <= size_li) ? x+jump : size_li;
        $('#artistGrid li:lt('+x+')').show();
		if(x+jump > size_li){  $('#loadMore').hide(); }
    });
    $('#showLess').click(function () {
        x=(x-jump<0) ? jump : x-jump;
        $('#artistGrid li').not(':lt('+x+')').hide();
    });
});

$(function() {
    var ele1  = $('#scroll1');
    var ele2  = $('#scroll2');
    var ele3  = $('#scroll3');
    
    var speed = 25, scroll = 5, scrolling;
    
    $('#scroll-up1').mouseenter(function() {
        // Scroll the element up
        scrolling = window.setInterval(function() {
            ele1.scrollTop( ele1.scrollTop() - scroll );
        }, speed);
    });
    $('#scroll-up2').mouseenter(function() {
        // Scroll the element up
        scrolling = window.setInterval(function() {
            ele2.scrollTop( ele2.scrollTop() - scroll );
        }, speed);
    });
    $('#scroll-up3').mouseenter(function() {
        // Scroll the element up
        scrolling = window.setInterval(function() {
            ele3.scrollTop( ele3.scrollTop() - scroll );
        }, speed);
    });

    
    $('#scroll-down1').mouseenter(function() {
        // Scroll the element down
        scrolling = window.setInterval(function() {
            ele1.scrollTop( ele1.scrollTop() + scroll );
        }, speed);
    });
    $('#scroll-down2').mouseenter(function() {
        // Scroll the element down
        scrolling = window.setInterval(function() {
            ele2.scrollTop( ele2.scrollTop() + scroll );
        }, speed);
    });
    $('#scroll-down3').mouseenter(function() {
        // Scroll the element down
        scrolling = window.setInterval(function() {
            ele3.scrollTop( ele3.scrollTop() + scroll );
        }, speed);
    });

    
    $('#scroll-up1, #scroll-down1').bind({
        click: function(e) {
            // Prevent the default click action
            e.preventDefault();
        },
        mouseleave: function() {
            if (scrolling) {
                window.clearInterval(scrolling);
                scrolling = false;
            }
        }
    });
    $('#scroll-up2, #scroll-down2').bind({
        click: function(e) {
            // Prevent the default click action
            e.preventDefault();
        },
        mouseleave: function() {
            if (scrolling) {
                window.clearInterval(scrolling);
                scrolling = false;
            }
        }
    });
    $('#scroll-up3, #scroll-down3').bind({
        click: function(e) {
            // Prevent the default click action
            e.preventDefault();
        },
        mouseleave: function() {
            if (scrolling) {
                window.clearInterval(scrolling);
                scrolling = false;
            }
        }
    });
});
