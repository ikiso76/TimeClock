-- Function: public.ph_alexandar_poruci_robu_iz_nyx_u_mp(integer)

-- DROP FUNCTION public.ph_alexandar_poruci_robu_iz_nyx_u_mp(integer);

CREATE OR REPLACE FUNCTION timing.get_orders(integer)
  RETURNS SETOF timing.stavke_orders AS
$BODY$
DECLARE aGrupa alias for $1;
        mystavka record;
        qRezultat text;
        qWhere text;
   /*
        qBroj integer;
        qAtribut integer;
       */ 
BEGIN
    qWhere:='';
    if aGrupa != 0 then
        qWhere:=' and dl.id_grupa='||aGrupa; 
    end if;


    for mystavka in 
    execute 'select 		coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  ),''''))::varchar(100) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak)::varchar,'''')::varchar(100) as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak))::varchar(100) as vozilo_itm,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta::varchar(100),
                                napomena,
                                dl.id_grupa,
                                 s.*
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	
                               left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
                               where d.id_def_dokumenta in (31716) and dok_status=''O''  and d.datum > (localtimestamp - ''3 month''::interval)'||qWhere

    loop
         return next mystavka;
    end loop;

    return;
END $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION timing.get_orders(integer)
  OWNER TO postgres;
  
/*
select * from timing.get_orders()

select 		coalesce(v.reg_oznaka,coalesce((select fa.vrednost from fin_atribut fa,fin_atribut_cvor fac 
                                                                where fa.id_fin_atribut_cvor=fac.id_fin_atribut_cvor and fac.id_atribut=16507 
                                                                and fa.id_ak=( vozilo.id_ak  )  )::varchar,'')) as registracija,
                                coalesce((select model from artikal where id_ak=vozilo.id_ak),'') as vozilo_naziv,
                                coalesce(kp.naziv,(select naziv from analitika where id_ak=vozilo.id_ak)) as vozilo_itm,
                                d.id_dokument, 
                                id_def_dokumenta, 
                                datum,
                                broj_dokumenta,
                                napomena,
                                dl.id_grupa,
                                 s.*
                                from dokument d
                                join rm_dokument rmd on (rmd.id_dokument=d.id_dokument)
                                left outer join analitika vozilo on (vozilo.id_ak=rmd.id_ak_porudzbina)
                                left outer join vozilo v on (v.id_ak=vozilo.id_ak)
                                left outer join kp_model kp on (kp.id_model=v.id_model)
                                left join  (select xs.id_nalog, ls.id_status_servis,brIzmena, ls.updated, najstanje, ls.id_korisnik
                                                 from (select gs.id_nalog, count(*) as  brIzmena,max (updated) as updated, max(id_status_servis) as najstanje 
                                                         from timing.servis gs 
                                                         group by 1 ) xs
                                                 join timing.servis ls on (ls.id_nalog=xs.id_nalog and ls.updated=xs.updated)
                                                 ) s on s.id_nalog=d.id_dokument	
                               left join timing.def_lokacija dl on dl.id_def=d.id_def_dokumenta		
                               where d.id_def_dokumenta in (31716) and dok_status='O'  and d.datum > (localtimestamp - '3 month'::interval)

                               

-- Type: neo_stavke_ffp

-- DROP TYPE neo_stavke_ffp;

CREATE TYPE timing.stavke_orders AS
   ( registracija character varying(100),
    vozilo_naziv character varying(100),
    vozilo_itm character varying(100),
    id_dokument integer,
    id_def_dokumenta integer,
    datum date,
    broj_dokumenta character varying(100),
    napomena text,
    id_grupa integer,
    id_nalog integer,
    id_status_servis integer,
    brizmena bigint,
    updated timestamp,
    najstanje integer,
    id_korisnik integer);
ALTER TYPE timing.stavke_orders
  OWNER TO postgres;
  */