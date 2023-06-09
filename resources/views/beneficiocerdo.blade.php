@extends('layouts.master-beneficiocerdo')
@extends('layouts.theme.app')

<br>
<br>
<br>

<div class="row sales layout-top-spacing">
    
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                   
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                       <a class="btn btn-primary float-right mt-3 mb-4" href="javascript:void(0)" id="createNewBook">Create New Book</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                    
                <div class="table-responsive">

            <table style="background: #0000000f; border: 1px solid #000;" class="table table-hover table-bordered data-table">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="20%">Title</th>
                        <th width="20%">Author</th>
                        <th width="20%">Cantidad</th>
                        <th width="30%">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
                           
          </div>              
            </div>
        
        </div>

    </div>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="bookForm" name="bookForm" class="form-horizontal">
                   <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Details</label>
                        <div class="col-sm-12">
                            <textarea id="author" name="author" required="" placeholder="Enter Author" class="form-control"></textarea>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

     
</div>






</div>
