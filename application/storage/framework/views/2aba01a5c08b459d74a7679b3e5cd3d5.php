<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right <?php echo e($page['list_page_actions_size'] ?? ''); ?> <?php echo e($page['list_page_container_class'] ?? ''); ?>"
    id="list-page-actions-container">
    <div id="list-page-actions">
        <!--SEARCH BOX-->
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search"
                data-url="<?php echo e($page['dynamic_search_url'] ?? ''); ?>" data-type="form" data-ajax-type="post"
                data-form-id="header-search" id="search_query" name="search_query"
                placeholder="<?php echo e(cleanLang(__('lang.search'))); ?>">
        </div>
    </div>
</div><?php /**PATH /Users/gilberto/Development/crm/grow/application/resources/views/landlord/subscriptions/actions/page-actions.blade.php ENDPATH**/ ?>