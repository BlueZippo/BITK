<div class="edit-stack-layout-controls"> <!-- https://getbootstrap.com/docs/4.1/components/navs/ -->
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            
            <a class="nav-item nav-link active" id="nav-layout-tabbed" data-toggle="tab" href="#layout-tabbed" role="tab" aria-controls="nav-home" aria-selected="true"><i class="far fa-folder"></i></a>

            <a class="nav-item nav-link" id="nav-layout-accordion" data-toggle="tab" href="#layout-accordion" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-list-ul"></i></a>

        </div>
    </nav>
</div>

<div class="tab-content" id="nav-create-layout">

        
    @include('stacks.links-tabbed')

    @include('stacks.links-accordion')

</div><!-- #nav-create-layout -->
