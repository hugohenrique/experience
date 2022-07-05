# Observações 

1. A depender da robustez da aplicação comecaria com uma estrutura monolítica e a medida que domínio fosse conhecido e implementado, iniciaria o processo de segregar em serviços menores, de acordo a necessidade.

2. Um detalhe simples, que pontuo com relação ao banco de dados, usaria UUID, ao invés de auto incremento para evitar colisões e também uma questão de segurança. Isso tratando-se de um cenário de um banco relacional. Para ir criando a estrutura de banco de dados, usuaria as Migrations.

3. Na parte da Transferência, usaria o Specification pattern para ter a certeza que todos os critérios seriam atendidos para, de fato, efetuar a Transação. No exemplo que implementei, utilizei o Doctrine, pois ele facilita o processo, por tratar com uma transação.

4. Na implementação do desafio, implementei o padrão CQS (Command Query Separation) com uma dose da arquitetura hexagonal, mas em um cenário real, acredito que o CQRS (Command Query Responsability Segratation) traria mais benefícios.

5. Por conta dos imprevistos que tive, não consegui implementar o testes unitários e de integração. Mas, tendo em vista a simplicidade do fluxo do desafio, talvez não teria tanta necessidade. Mas é algo que gosto bastante de utilizar.
