
 -- DROP FUNCTION timing.navi_klijenti() 
 
CREATE OR REPLACE FUNCTION timing.navi_klijenti()
  RETURNS SETOF record AS
$BODY$
DECLARE rRed record;
BEGIN
    for rRed in (select kl.id_ak,
			anal_konto, an.naziv,
			adresa, telefon,email
			
                             from klijent kl
                                 join analitika an on (an.id_ak=kl.id_ak)
                                 
                             where an.id_gru_an in (10099)
                                
                            )
         
    loop
        return next rRed;
    end loop;

    return;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION timing.navi_klijenti()
  OWNER TO postgres;


 select * from  timing.navi_klijenti() as (id_ak integer,anal_konto varchar(20), naziv varchar(100),adresa varchar(200), telefon varchar(50),email varchar(100))