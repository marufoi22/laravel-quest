@extends('layouts.default')

<header>
  @include('layouts.header')
</header>

<div class="home-page">
  <div class="banner">
    <div class="container">
      <h1 class="logo-font">conduit</h1>
      <p>A place to share your knowledge.</p>
    </div>
  </div>

  <div class="container page">
    <div class="row">
      <div class="col-md-9">
        <div class="feed-toggle">
          <ul class="nav nav-pills outline-active">
            <!-- TODO ログインしている場合のみ表示-->
            <li class="nav-item">
              <a class="nav-link" href="">Your Feed</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="">Global Feed</a>
            </li>
          </ul>
        </div>

        @foreach($articles as $article)
        <div class="article-preview">
          <div class="article-meta">
            {{-- <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a> --}}
            <div class="info">
              {{-- <a href="/profile/eric-simons" class="author">Eric Simons</a> --}}
              <span class="date">{{ $article->created_at }}</span>
            </div>
            <!-- お気に入りは実装不要-->
            {{-- <button class="btn btn-outline-primary btn-sm pull-xs-right">
              <i class="ion-heart"></i> 29
            </button> --}}
          </div>
          <a href="{{ route('articles.show', ['id' => $article->id] )}}" class="preview-link">
            <h1 name="title">{{ $article->title }}</h1>
            <p name="content">{{ $article->content }}</p>
            <span>Read more...</span>
            <ul class="tag-list">
              <!-- 記事に紐づくタグを表示する -->
              @foreach($article->tags as $tag)
              <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
              @endforeach
            </ul>
          </a>
        </div>
        @endforeach
        <!-- ページネーションリンクの表示 -->
          <ul class="pagination pagination-lg justify-content-center">
          {{ $articles->links('vendor.pagination.bootstrap-4') }}
          </ul>
      </div>
      <div class="col-md-3">
        <div class="sidebar">
          <p>Popular Tags</p>

          <div class="tag-list">
            @foreach($tags as $tag)
            <a href="" class="tag-pill tag-default">{{ $tag->name }}</a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')
