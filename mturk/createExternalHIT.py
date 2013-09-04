from boto.mturk.connection import MTurkConnection
from boto.mturk.question import ExternalQuestion

SANDBOX = True
AWS_ACCESS_KEY = "ACCESS_KEY"
AWS_SECRET_KEY = "SECRET_KEY"

NUMBER_OF_HITS = 1
NUMBER_OF_ASSIGNMENTS = 3
LIFETIME = 60 * 24 * 2
TITLE = 'Label an image'
EXPLANATION = 'Tag the image with objects that you can see in it'

def create_hits():
	if SANDBOX:
		mturkurl = 'mechanicalturk.sandbox.amazonaws.com'
	else:
		mturkurl = 'mechanicalturk.amazonaws.com'

    q = ExternalQuestion(external_url="http://census.stanford.edu/client/demo.html", frame_height=800)
    conn = MTurkConnection(aws_access_key_id=AWS_ACCESS_KEY, aws_secret_access_key=AWS_SECRET_KEY, host=mturkurl)
    keywords=['census']
    for i in range(0, NUMBER_OF_HITS):
        create_hit_rs = conn.create_hit(question=q, lifetime=LIFETIME,max_assignments=NUMBER_OF_ASSIGNMENTS,title=TITLE, keywords=keywords,reward = 0.05, duration=60*6,approval_delay=60*60, annotation=EXPLANATION)
    assert(create_hit_rs.status == True)
  
if __name__ == "__main__":
    create_hits()
  