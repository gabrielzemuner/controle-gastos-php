# Controle Gastos PHP

Projeto de estudo em PHP, com foco primeiro em procedural e depois em migração gradual para OO.

## Pastas

- `procedural/`  
  Implementação procedural (funções, controller + view, componentes).
- `old_oo/`  
  Versão antiga OO (ignorada no git).

## Objetivos

- praticar PHP puro (procedural)
- organizar controller/view/componentes
- evoluir para OO aos poucos

## Estrutura (procedural)

- `index.php` — entrada da aplicação
- `controllers/` — lógica da página
- `views/` — HTML e views
- `components/` — componentes reutilizáveis e layouts
- `inc/` — helpers e configuração
- `public/` — CSS/estilos
- `data/` — JSON com os dados

## Como rodar

- use um servidor local (ex: Laragon)
- acesse:  
  `http://localhost/controle-gastos-php/procedural/index.php`

## Próximos passos

- melhorar paginação
- ajustes de validação
- iniciar migração gradual para OO
