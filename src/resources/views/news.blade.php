@extends('layouts.app', ['activePage' => 'news', 'titlePage' => __('News')])
@section('content')
<title>News</title>
<link href="css/news.css" rel="stylesheet">
<link href="js/news.js" rel="stylesheet">
<script src="https://unpkg.com/feather-icons"></script>
<div class="label-content">
    <h1 class="text-center text-white text-xl py-2">駐輪場オーナー管理システム</h1>
    <h2>ニュース一覧</h2>
</div>
<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid ">
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <form class="btn-search search-date d-flex me-4" role="search">
                <input class="form-control me-2" type="date" aria-label="Search" id="release_date">
                <button class="btn btn-outline-success bg-white" type="submit">検索</button>
            </form>
            <form class="btn-search search-title d-flex text-righ ms-4" role="search">
                <input class="form-control me-2" type="search" placeholder="タイトルを検索" aria-label="Search" id="tittle">
                <button class="btn btn-outline-primary bg-white" type="submit">検索</button>
            </form>
        </div>
    </div>
    </nav>
    <div class="mt-4">
        <button class="btn-add fw-bold bg-white" data-bs-target="#ModalAdd" data-bs-toggle="modal">
            <i data-feather="plus" class="feather-32"></i>
            <script>
                feather.replace()
            </script> 
                ニュースを追加
        </button>
    </div>
    <div class="list-news mt-8 bg-white">
        <table class="table table-bordered mt-8">
        <thead class="text-white text-center">
            <tr>
            <th scope="col">ID</th>
            <th scope="col">題名</th>
            <th scope="col">情報</th>
            <th scope="col">発売日</th>
            <th scope="col">アクション</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">1</th>
            <td id="title">Aut sit a ut.</td>
            <td>Doloremque eveniet reprehenderit odit asperiores quia perferendis enim velit et veritatis voluptatibus corrupti libero ea cumque.</td>
            <td id="release_date">26/12/2022</td>
            <td>
                <div class="d-flex my-auto">
                    <button type="button" class="btn-edit m-auto" data-bs-target="#ModalEdit" data-bs-toggle="modal" title="編集">
                        <div class="text-center">
                            <i data-feather="edit" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                    <button class="btn-delete ms-1" data-bs-target="#ModalConfirmDelete" data-bs-toggle="modal" title="消去">
                        <div class="btn-delete text-center">
                            <i data-feather="trash-2" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                </div>
            </td>
            </tr>
            <tr>
            <th scope="row">2</th>
            <td id="title">Amet corrupti voluptatem voluptates aut.</td>
            <td>Thornton</td>
            <td id="release_date">26/12/2022</td>
            <td>
                <div class="d-flex my-auto">
                    <button class="btn-edit m-auto" data-bs-target="#ModalEdit" data-bs-toggle="modal" title="編集">
                        <div class="text-center">
                            <i data-feather="edit" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                    <button class="btn-delete ms-1" data-bs-target="#ModalConfirmDelete" data-bs-toggle="modal" title="消去">
                        <div class="btn-delete text-center">
                            <i data-feather="trash-2" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                </div>
            </td>
            </tr>
            <tr>
            <th scope="row">3</th>
            <td id="title">Et similique quaerat perferendis.</td>
            <td>Et similique quaerat perferendis.</td>
            <td id="release_date">23/12/2022</td>
            <td>
                <div class="d-flex my-auto">
                    <button type="button" class="btn-edit m-auto" data-bs-target="#ModalEdit" data-bs-toggle="modal" title="編集">
                        <div class="text-center">
                            <i data-feather="edit" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                    <button class="btn-delete ms-1" data-bs-target="#ModalConfirmDelete" data-bs-toggle="modal" title="消去">
                        <div class="btn-delete text-center">
                            <i data-feather="trash-2" class="feather-24"></i>
                            <script>
                                feather.replace()
                            </script>
                        </div>
                    </button>
                </div>
            </td>
            </tr>
        </tbody>
        </table>
    </div>
    
    <nav class="pagination d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">前</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">次</a></li>
        </ul>
    </nav>
</div>

<!-- Modal Add -->
<div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAdd" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="exampleModalLabel">新しいタイトル</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ms-4">
        <input type="text" placeholder="タイトルを入力" class="add-newstitle mx-auto" id="tittle"/>
        <textarea type="text" placeholder="コンテンツを入力してください" class="add-newscontent mt-2" id="information"></textarea>
        <input type="date" class="add-newsdate mt-2" id="release_date" />
      </div>
      <div class="modalfooter">
        <img src="{{ asset('logo.jpg') }}" alt="logo">
        <div class="btn-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" data-bs-target="#ModalConfirmAdd" data-bs-toggle="modal" class="btn-confirm btn">セーブ</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Add -->

<!-- Modal Confirm Add -->
<div class="modal fade" id="ModalConfirmAdd" tabindex="-1" aria-labelledby="ModalConfirmAdd" aria-hidden="true">
  <div class="modal-dialog modal-confirmadd">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ms-4 text-center">
        <label class="fw-bold fs-3">本当に を変更しますか?</label>
      </div>
      <div class="modalfooter">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" class="btn-confirm btn">確認</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Add -->

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
  <div class="modal-dialog modal-edit">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title fw-bold" id="exampleModalLabel">ニュースを編集</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ms-4">
      <input type="text" placeholder="タイトルを入力" class="add-newstitle mx-auto" id="tittle"/>
        <textarea type="text" placeholder="コンテンツを入力してください" class="add-newscontent mt-2" id="information"></textarea>
        <input type="date" class="add-newsdate mt-2" id="release_date" />
      </div>
      <div class="modalfooter">
        <img src="{{ asset('logo.jpg') }}" alt="logo">
        <div class="btn-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" data-bs-target="#ModalConfirmEdit" data-bs-toggle="modal" class="btn-confirm btn">セーブ</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Edit -->

<!-- Modal Confirm Edit -->
<div class="modal fade" id="ModalConfirmEdit" tabindex="-1" aria-labelledby="ModalConfirmEdit" aria-hidden="true">
  <div class="modal-dialog modal-confirmadd">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ms-4 text-center">
        <label class="fw-bold fs-3">本当に を変更しますか?</label>
      </div>
      <div class="modalfooter">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" class="btn-confirm btn">確認</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Edit -->

<!-- Modal Confirm Delete -->
<div class="modal fade" id="ModalConfirmDelete" tabindex="-1" aria-labelledby="ModalConfirmDelete" aria-hidden="true">
  <div class="modal-dialog modal-confirmadd">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ms-4 text-center">
        <div>
            <i data-feather="alert-triangle" class="icon-warning feather-32"></i>
                <script>
                    feather.replace()
                </script>
        </div>
        <label class="fw-bold fs-3">本当に を変更しますか?</label>
      </div>
      <div class="modalfooter">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
            <button type="button" class="btn-confirm btn">確認</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Confirm Delete -->
<a href="#" data-bs-toggle="tooltip" title="Some tooltip text!">Hover over me</a>

<!-- Generated markup by the plugin -->

@endsection