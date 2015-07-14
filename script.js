/*!
 * DokuWiki Bootstrap Wrapper Plugin
 *
 * Home     http://dokuwiki.org/plugin:bootswrapper
 * Author   Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * License  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

jQuery(document).ready(function() {

    jQuery('.bs-wrap[data-toggle="tooltip"]').tooltip();

    jQuery('.bs-wrap[data-img-type]').each(function() {

      var $img_wrap = jQuery(this),
          img_data  = $img_wrap.data();

      $img_wrap.find('img').addClass(['img-', img_data.imgType].join(''));

    });

    jQuery('.bs-wrap[data-nav-type]').each(function() {

        var $nav_wrap = jQuery(this),
            nav_data  = $nav_wrap.data(),
            nav_class = ['nav'];

        for (key in nav_data) {

            var value = nav_data[key];

            switch (key) {
                case 'navType':
                    nav_class.push(['nav-', value].join(''));
                    break;
                case 'navStacked':
                    if (value) nav_class.push('nav-stacked');
                    break;
                case 'navJustified':
                    if (value) nav_class.push('nav-justified');
                    break;
            }

        }

        $nav_wrap.find('ul:first').addClass(nav_class.join(' '));
        $nav_wrap.find('div.li *').unwrap();
        $nav_wrap.find('li').attr('role', 'presentation');
        $nav_wrap.find('.curid').parent('li').addClass('active');

        // Drop-down menu
        $nav_wrap.find('ul li ul')
            .addClass('dropdown-menu')
            .parent('li')
            .addClass('dropdown');

        $nav_wrap.find('.dropdown div.li').replaceWith(function() {
            return jQuery('<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" />')
                .html(jQuery(this).contents())
                .append(' <span class="caret"/>');
        });

        // Tab panels
        if ($nav_wrap.find('.tab-pane').length) {

            if (! $nav_wrap.find('.tab-content').length) {
                $nav_wrap.find('.tab-pane').wrapAll(jQuery('<div class="tab-content"/>'));
            }

            $nav_wrap.find('a').attr('data-toggle', 'tab').attr('role', 'tab');

            if (nav_data.navFade) {
                $nav_wrap.find('.tab-content .tab-pane').addClass('fade');
            }
        
            $nav_wrap.find('.nav a:first').tab('show');           
        
        }

    });

    jQuery('.bs-wrap[data-btn-type]').each(function() {

        var $btn_wrap = jQuery(this),
            btn_data  = $btn_wrap.data(),
            $btn_link = $btn_wrap.find('a'),
            btn_class = ['btn'];

        // Add Fake link
        if (! $btn_link.length) {

            btn_label = $btn_wrap.html();
            $btn_wrap.html('');

            $btn_link  = jQuery('<a href="#"/>').html(btn_label);
            jQuery(this).append($btn_link);

        }

        for (key in btn_data) {

            var value = btn_data[key];

            switch (key) {
                case 'btnType':
                case 'btnSize':
                    btn_class.push(['btn-', value].join(''));
                    break;
                case 'btnBlock':
                    btn_class.push('btn-block');
                    break;
                case 'btnIcon':
                    var icon = ['<i class="', value, '"/> '].join('');
                    $btn_link.prepend(icon);
                    break;
            }

        }

        $btn_link.addClass(btn_class.join(' '));
        $btn_link.attr('role', 'button');

    });

});
