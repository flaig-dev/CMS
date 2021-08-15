{block name=nav}
  {foreach $subjects as $subject}
    <li class='nav-item'>
      <a class='nav-link' href='subject.php?id={$subject.id}'> {$subject.title}</a>
  </li>
  {/foreach}
{/block}
{block name=body}  
  <h1>{$heading}</h1>
  <h2>{$title}</h2>
  <p>{$paragraph}</p>
{/block} 