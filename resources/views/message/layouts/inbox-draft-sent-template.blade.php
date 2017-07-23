@extends('message.main')

@section('Compose-Name')
  @include('message.partials.create-button')
@endsection

<!-- include content -->
@section('message-content')
    @if ($messages->count())
      <div class="mailbox-controls">
        <div class="row">
          <div class="pull-right margin-right-lg margin-bottom-md">
            @if(isset($messages->from))
              {{ $messages->from . ' - ' . $messages->to. ' / ' . $messages->total }}
              <div class="btn-group">
                <a type="button" href="{{ $messages->next_page_url }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>
                <a type="button" href="{{ $messages->prev_page_url }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
              </div>
            @endif
          </div>
        </div>
      </div>
      <div id="delete-selection-container" class="hidden margin-bottom-sm">
          <button type="button" id="btn-delete-selections" class="btn btn-default btn-sm" data-toggle="tooltip">
          <i class="fa fa-trash-o"></i></button>
      </div>
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <tbody>

            @yield('main-messages-area')

          </tbody>
        </table>
        <form id="table_selection" action="{{ url('/teams/' . $team_id . '/messages/' . $type . '/actions') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="deleteSection[]" id="deleteSection">
        </form>
        <!-- /.table -->
      </div>
    @else
        <div class="alert alert-info text-center margin-top-lg"><strong>
            @yield('error-message')
        </strong></div>
    @endif

@endsection

@section('added_js')
  <script type="text/javascript">
    $(function () {
        $('.checkbox_select').click(function() {
            var count = $('.checkbox_select:checked').length;
            if (count > 0) {
                if (count > 1) {
                  $('#btn-delete-selections').attr('title', 'Delete Selections');
                } else {
                  $('#btn-delete-selections').attr('title', 'Delete Selection');
                }
                $('#delete-selection-container').removeClass('hidden');
            } else {
                if (! $('#delete-selection-container').hasClass('hidden')) {
                    $('#delete-selection-container').addClass('hidden');
                }
            }
        });

        $('#btn-delete-selections').click(function() {
            swal({
                title: 'Are you sure?',
                titleText: 'Are you sure?',
                text: "You are moving the message(s) to Trash!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Go Ahead!'
            }).then(function () {
                var deleteList = Array();
                $('.checkbox_select:checked').each(function() {
                    // console.log($(this).val());
                    // return;
                    deleteList.push($(this).val());
                });
                $('#deleteSection').val(deleteList);
                $('#table_selection').submit();
            }).catch(swal.noop);
        });
    });
  </script>
@endsection
