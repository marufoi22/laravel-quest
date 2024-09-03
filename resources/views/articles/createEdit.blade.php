@extends('layouts.default')

<header>
  @include('layouts.header')
</header>

<div class="editor-page">
  <div class="container page">
    <div class="row">
      <div class="col-md-10 offset-md-1 col-xs-12">
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

        <form id="article-form" method="post" action="{{ route('articles.store')}}">
          @csrf
          <fieldset>
            <fieldset class="form-group">
              <input type="text" name="title" class="form-control form-control-lg" placeholder="Article Title" value="{{ $article->title ?? "" }}"/>
            </fieldset>
            <fieldset class="form-group">
              <input type="text" name="topic" class="form-control" placeholder="What's this article about?" value="{{ $article->topic ?? ""}}"/>
            </fieldset>
            <fieldset class="form-group">
              <textarea
                name="content"
                class="form-control"
                rows="8"
                placeholder="Write your article (in markdown)"
              >{{ $article->content ?? ""}}</textarea>
            </fieldset>
            <fieldset class="form-group">
              <input type="text" name="tags" id="tag-form" class="form-control" placeholder="Enter tags"/>
              <div name="tags" class="tag-list">
                <!-- DOM操作でタグを追加 -->
              </div>
            </fieldset>
            <button class="btn btn-lg pull-xs-right btn-primary" type="button">
              Publish Article
            </button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')

<script defer>

const tagList = [];
// タグ操作

//登録
document.addEventListener('DOMContentLoaded', function() {
    // const TagList = document.querySelector('.tag-list');
    const tagInput = document.querySelector('#tag-form');

    tagInput.addEventListener('keydown', (e) =>
    {
      if(e.key === 'Enter'){
      e.preventDefault();
      //spanタグ
      const newTag = document.createElement('span');
      newTag.classList.add('tag-default', 'tag-pill');

      //iタグ
      const TagName = document.createElement('i');
      TagName.classList.add('ion-close-round');
      // TagName.setAttribute('name', 'list' + (TagList.childElementCount + 1));
      const tagValue = tagInput.value;
      TagName.innerText = tagValue;
      tagList.push(tagValue);

      //DOM操作
      newTag.appendChild(TagName);
      const Tag = document.querySelector('.tag-list');
      Tag.appendChild(newTag);

      // // リセット
      tagInput.value = "";
      };

      // TODO削除機能の実装
      // const DeleteTag = document.querySelector('ion-close-round');
      // DeleteTag.addEventListener('click', (event) =>
      // {
      // if(event.target.classList.contains('ion-close-round')){
      //   const tag = event.target.parentElement;
//       //   TagName.removeChild(tag);
//       }
//   })
});
});

document.querySelector('button').addEventListener('click', function() {
  const tagInput = document.querySelector('#tag-form');
  tagInput.value = JSON.stringify(tagList);
  document.querySelector('#article-form').submit();
});
</script>
