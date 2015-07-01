/*!
 * DokuWiki Bootstrap Wrapper Plugin
 *
 * Home     http://dokuwiki.org/plugin:bootswrap
 * Author   Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * License  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

jQuery(document).ready(function() {

    jQuery('[data-toggle="tooltip"]').tooltip();

    jQuery('[data-btn-type]').each(function() {

        var btnWrap  = jQuery(this),
            btnData  = btnWrap.data(),
            btnLink  = btnWrap.find('a'),
            btnClass = ['btn'];

        if (! btnLink.length) {

            btnLabel = btnWrap.html();
            btnWrap.html('');

            btnLink  = jQuery('<a href="#"/>').html(btnLabel);
            jQuery(this).append(btnLink);

        }

        for (key in btnData) {

            var value = btnData[key];

            switch (key) {
                case 'btnType':
                case 'btnSize':
                    btnClass.push(['btn-', value].join(''));
                    break;
                case 'btnBlock':
                    btnClass.push('btn-block');
                    break;
                case 'btnIcon':
                    var icon = ['<i class="', value, '"/> '].join('');
                    btnLink.prepend(icon);
                    break;
            }

        }

        btnLink.addClass(btnClass.join(' '));
        btnLink.attr('role', 'button');

    });

});
