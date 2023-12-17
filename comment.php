<div class="comments-section">
  <h2>Commenti degli Utenti</h2>
  <div class="comments-container">
    <!-- I commenti verranno inseriti qui -->
    <?php 
    $comments = genericSelect("commenti", ['*'], "articolo=?", [$_GET['id']], $con);
    if(isset($comments)){
        if (is_array($comments) && !is_array($comments[0])) {   // Caso in cui la select ha restituito un singolo elemento
            $comments = [$comments]; 
        }
        foreach ($comments as $comment) {
            echo 
                "<div class=\"comment\">
                <p class=\"comment-author\">" . $comment['utente'] . "</p>
                <p class=\"comment-date\">" . $comment['data_inserimento'] . "</p>
                <p class=\"comment-body\">" . $comment['testo'] . "</p>" . 
                "</div>";
        }
    }
    ?>

    <div class="comment">
      <p class="comment-author">Mario Rossi</p>
      <p class="comment-date">12 dicembre 2023</p>
      <p class="comment-body">Ottimo articolo, molto informativo!</p>
    </div>
    <!-- Altri commenti ... -->
  </div>

  <div class="comment-form">
    <h3>Lascia un commento</h3>
    <form id="commentForm" action="addComment.php" method="post">
        <textarea id="comment" name="comment" placeholder="Scrivi un commento..." required></textarea>
        <input hidden type="text" id="article" name="article" value="<?php echo $_GET['id']; ?>">
        <input hidden type="text" id="user" name="user" value="<?php echo $_SESSION['email']; ?>">
        <button type="submit" id="submit_button">Invia</button>
    </form>
  </div>
</div>
