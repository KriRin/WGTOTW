<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        ''  => [
            'text'  => 'Hem',
            'url'   => $this->di->get('url')->create(''),
            'title' => 'Visa startsidan'
        ],


        // This is a menu item
        'questions'  => [
            'text'  => 'Frågor',
            'url'   => $this->di->get('url')->create('posts/view'),
            'title' => 'Visa alla frågor',
            
            'submenu' => [
                'items' => [
                    'create questions' => [
                        'text' => 'Ställ en fråga',
                        'url'  => $this->di->get('url')->create('posts/createpost/1'),
                        'title' => 'Ställ en ny fråga',
                        'mark-if-parent-of' => 'questions'
                    ],
                ],
            ],
        ],
        
        'tags' => [
            'text' => 'Taggar',
            'url' => $this->di->get('url')->create('posts/viewTags'),
            'title' => 'Visa taggar'
        ],
        
        'users' => [
            'text'  => 'Användare',
            'url'   => $this->di->get('url')->create('users/list'),
            'title' => 'Visa alla användare'
        ],

        'about' => [
            'text'  => 'Om oss',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Info om oss'
        ],
        
    ],
        
        
        
        
        
        
    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    
];
