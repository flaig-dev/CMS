{block name=nav}
  {foreach $subjects as $subject}
    <li class='nav-item'>
      <a class='nav-link' href='subject.php?id={$subject.id}'> {$subject.title}</a>
  </li>
  {/foreach}
{/block}
{block name=body}  
  <h1>{$heading}</h1>
  <p>{$paragraph}</p>
  <ul>
    {foreach $pages as $page}
      <a href='page.php?id={$page.id}&subjectId={$page.subjectId}'> {$page.title}</a>
      <br />
    {/foreach}
  </ul>
{/block} 