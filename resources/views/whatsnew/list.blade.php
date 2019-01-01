<div class="modal fade whats-new-modal" tabindex="-1" role="dialog" aria-labelledby="whatsNewModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-gift"></i> What's New</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      
        <div class="modal-body">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#whats-new-advisory" data-toggle="tab" aria-controls="advisory-tab">Advisories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#whats-new-news" data-toggle="tab" aria-controls="news-tab">News</a>
                </li>  
            </ul>

            <div class="tab-content" id="whatsNewTabContent">

                <div class="tab-pane fade show active" id="whats-new-advisory" role="tabpanel" aria-labelledby="advisory-tab">
                    {!! $advisory !!}
                </div>

                <div class="tab-pane fade" id="whats-new-news" role="tabpanel" aria-labelledby="news-tab">
                    {!! $news !!}
                </div>

            </div>

        </div>

        <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div>