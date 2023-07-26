<?php

namespace App\Extensions\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class MatchAgainst extends FunctionNode
{
    /** @var array list of \Doctrine\ORM\Query\AST\PathExpression */
    protected $pathExp = null;
    /** @var string */
    protected $against = null;
    /** @var bool */
    protected $booleanMode = false;
    /** @var bool */
    protected $queryExpansion = false;

    public function parse(Parser $parser)
    {
        // match
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        // first Path Expression is mandatory
        $this->pathExp = [];
        $this->pathExp[] = $parser->StateFieldPathExpression();
        // Subsequent Path Expressions are optional
        $lexer = $parser->getLexer();
        while ($lexer->isNextToken(Lexer::T_COMMA)) {
            $parser->match(Lexer::T_COMMA);
            $this->pathExp[] = $parser->StateFieldPathExpression();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        // against
        if (strtolower($lexer->lookahead['value']) !== 'against') {
            $parser->syntaxError('against');
        }
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->against = $parser->StringPrimary();
        if (strtolower($lexer->lookahead['value']) === 'boolean') {
            $parser->match(Lexer::T_IDENTIFIER);
            $this->booleanMode = true;
        }
        if (strtolower($lexer->lookahead['value']) === 'expand') {
            $parser->match(Lexer::T_IDENTIFIER);
            $this->queryExpansion = true;
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $walker)
    {
        $fields = [];
        foreach ($this->pathExp as $pathExp) {
            $fields[] = $pathExp->dispatch($walker);
        }
        $against = $walker->walkStringPrimary($this->against)
            . ($this->booleanMode ? ' IN BOOLEAN MODE' : '')
            . ($this->queryExpansion ? ' WITH QUERY EXPANSION' : '');
        return sprintf('MATCH (%s) AGAINST (%s)', implode(', ', $fields), $against);
    }
}
//La classe que vous avez fournie est une classe personnalisée MatchAgainst qui étend
// la classe FunctionNode de Doctrine. Cette classe est utilisée pour créer une fonction
// personnalisée MATCH AGAINST pour les requêtes DQL.
//
//
//      protected $pathExp: Cette propriété est utilisée pour stocker les expressions
//      de chemin (Path Expressions) fournies en tant qu'arguments à la fonction MATCH AGAINST.
//      Une expression de chemin représente une référence à une propriété ou une relation d'une entité dans une
//      requête DQL.
//
//      protected $against: Cette propriété est utilisée pour stocker l'argument against de la fonction
//      MATCH AGAINST, qui représente la chaîne de recherche.
//
//       protected $booleanMode: Cette propriété est utilisée pour indiquer si le mode booléen (IN BOOLEAN MODE)
//       est activé pour la recherche.
//
//      protected $queryExpansion: Cette propriété est utilisée pour indiquer si l'expansion de requête
//      (WITH QUERY EXPANSION) est activée pour la recherche.
//
//      La méthode parse(Parser $parser): Cette méthode est utilisée pour analyser la syntaxe de la
//      fonction MATCH AGAINST dans une requête DQL. Elle extrait les expressions de chemin et les options
//      (against, boolean, expand) fournies  en tant qu'arguments à la fonction.
//
//      La méthode getSql(SqlWalker $walker): Cette méthode est utilisée pour générer la partie SQL correspondante
//      de la fonction MATCH AGAINST dans une requête SQL. Elle utilise les expressions de chemin et les options
//      analysées pour construire la clause SQL MATCH (...) AGAINST (...) avec les options correspondantes.
//
//      En résumé, cette classe personnalisée permet d'étendre les fonctionnalités de Doctrine en ajoutant une
//      fonction MATCH AGAINST personnalisée aux requêtes DQL, qui peut être utilisée pour effectuer des recherches
//      en texte intégral.
