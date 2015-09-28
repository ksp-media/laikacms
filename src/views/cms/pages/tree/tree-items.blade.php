@if($treeItem['childs'] && ($treeItem->pageIsInPath($page)))
<ul>
    @foreach ($treeItem['childs'] as $treeParentPage)

    <li @if($treeParentPage->id == $page->id) class="active" @endif><a  href="/{{$cmsprefix}}/cms/page/{{$treeParentPage->id}}/edit">{{$treeParentPage->title}}</a>
    @include('laikacms::cms.pages.tree.tree-items', array('type' => 'li', 'treeItem' => $treeParentPage))
    </li>

    @endforeach
</ul>
@endif