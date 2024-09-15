@extends('layouts.default')

<header>
  @include('layouts.header')
  <style>
    .ion-trash-a {
      border: none;
    }
    .card-footer {
      display: flex;
    }
    .form_area {
      margin-left: auto;
    }
    .article_form-area {
      display: flex;
    }
  </style>
</header>

<div class="article-page">
  <div class="banner">
    <div class="container">
      <h1>{{ $article->title }}</h1>
      {{-- <h1>How to build webapps that scale</h1> --}}

      <div class=article-meta">
        <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
        <div class="info">
          <a href="/profile/eric-simons" class="author">Eric Simons</a>
          <span class="date">January 20th</span>
        </div>
        <div class="article_form-area">
          <form method="get" action="{{ route('articles.edit', ['id' => $article->id ]) }}">
            <button class="btn btn-sm btn-outline-secondary">
              <i class="ion-edit"></i> Edit Article
            </button>
          </form>
          <form method="post" action="{{ route('articles.destroy', ['id' => $article->id ])}}">
              @csrf
            <button class="btn btn-sm btn-outline-danger">
              <i class="ion-trash-a"></i> Delete Article
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container page">
    <div class="row article-content">
      <div class="col-md-12">
        <p>
        {{ $article->content }}
        </p>
        <ul class="tag-list">
          @foreach($tags as $tag)
          <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <hr />
    <div class="article-actions">
      <div class="article-meta">
        <a href="profile.html"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
        <div class="info">
          <a href="" class="author">Eric Simons</a>
          <span class="date">January 20th</span>
        </div>
      </div>
    </div>

    <!-- コメント -->
    <!-- コメント登録 -->
    <!-- バリデーションチェック-->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="row">
      <div class="col-xs-12 col-md-8 offset-md-2">
        <form class="card comment-form" method="post" action="{{ route('comments.store', ['id' => $article->id]) }}">
          @csrf
          <div class="card-block">
            <textarea class="form-control" name="comment" placeholder="Write a comment..." rows="3"></textarea>
          </div>
          <div class="card-footer">
            <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
            <button type="submit" class="btn btn-sm btn-primary">Post Comment</button>
          </div>
        </form>

        <!-- コメント一覧部分 -->
        @foreach($comments as $comment)
        <div class="card">
          <div class="card-block">
            <p class="card-text">
              {{ $comment->comment }}
            </p>
          </div>
          <div class="card-footer">
            <a href="/profile/author" class="comment-author">
              <img src="http://i.imgur.com/Qr71crq.jpg" class="comment-author-img" />
            </a>
            &nbsp;
            <a href="/profile/jacob-schmidt" class="comment-author">Jacob Schmidt</a>
            <span class="date-posted">Dec 29th</span>
            <form class="form_area" method="post" action="{{ route('comments.destroy', ['id' => $comment->id ])}}">
              @csrf
              <button class="ion-trash-a" type="submit"></button>
            </form>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')
